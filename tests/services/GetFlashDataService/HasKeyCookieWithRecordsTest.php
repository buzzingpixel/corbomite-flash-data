<?php

declare(strict_types=1);

namespace corbomite\tests\services\GetFlashDataService;

use Atlas\Mapper\MapperSelect;
use buzzingpixel\cookieapi\Cookie;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\Orm;
use corbomite\db\PDO;
use corbomite\di\Di;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\GetFlashDataService;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use stdClass;
use Throwable;

class HasKeyCookieWithRecordsTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $pdo = self::createMock(PDO::class);

        $pdo->expects(self::never())
            ->method('prepare');

        $keyCookie = new Cookie('flash_data_key', 'bar');

        $cookieApi = self::createMock(CookieApiInterface::class);

        $cookieApi->expects(self::once())
            ->method('retrieveCookie')
            ->with(self::equalTo('flash_data_key'))
            ->willReturn($keyCookie);

        $mapperSelect = self::createMock(MapperSelect::class);

        $mapperSelect->expects(self::once())
            ->method('where')
            ->with(
                self::equalTo('guid = '),
                self::equalTo('UuidBytesTest')
            )
            ->willReturn($mapperSelect);

        $recordOneDate = new DateTime();
        $recordOneDate->setTimezone(new DateTimeZone('UTC'));

        /** @var Uuid $guidOne */
        $guidOne       = Di::diContainer()->get('UuidFactoryWithOrderedTimeCodec')->uuid1();
        $guidOneString = $guidOne->toString();
        $guidOneBytes  = $guidOne->getBytes();

        $recordOne                     = new stdClass();
        $recordOne->data               = '{"data": "thing"}';
        $recordOne->added_at           = $recordOneDate->format('Y-m-d H:i:s');
        $recordOne->added_at_time_zone = $recordOneDate->getTimezone()->getName();
        $recordOne->guid               = $guidOneBytes;
        $recordOne->name               = 'guidOneName';

        $recordTwoDate = new DateTime();
        $recordTwoDate->setTimezone(new DateTimeZone('UTC'));

        /** @var Uuid $guidTwo */
        $guidTwo       = Di::diContainer()->get('UuidFactoryWithOrderedTimeCodec')->uuid1();
        $guidTwoString = $guidTwo->toString();
        $guidTwoBytes  = $guidTwo->getBytes();

        $recordTwo                     = new stdClass();
        $recordTwo->data               = '';
        $recordTwo->added_at           = $recordTwoDate->format('Y-m-d H:i:s');
        $recordTwo->added_at_time_zone = $recordTwoDate->getTimezone()->getName();
        $recordTwo->guid               = $guidTwoBytes;
        $recordTwo->name               = 'guidTwoName';

        $mapperSelect->expects(self::once())
            ->method('fetchRecords')
            ->willReturn([$recordOne, $recordTwo]);

        $orm = self::createMock(Orm::class);

        $orm->expects(self::once())
            ->method('select')
            ->with(self::equalTo(FlashDatum::class))
            ->willReturn($mapperSelect);

        $ormFactory = self::createMock(Factory::class);

        $ormFactory->expects(self::once())
            ->method('makeOrm')
            ->willReturn($orm);

        $flashDataStoreModel = new FlashDataStoreModel();

        $uuid = self::createMock(Uuid::class);

        $uuid->expects(self::once())
            ->method('getBytes')
            ->willReturn('UuidBytesTest');

        $uuidFactory = self::createMock(UuidFactory::class);

        $uuidFactory->expects(self::once())
            ->method('fromString')
            ->with(self::equalTo('bar'))
            ->willReturn($uuid);

        /** @noinspection PhpParamsInspection */
        $service = new GetFlashDataService(
            $pdo,
            $ormFactory,
            $cookieApi,
            $uuidFactory,
            $flashDataStoreModel
        );

        $returnData = $service(false);

        self::assertSame($flashDataStoreModel, $returnData);

        $one = $returnData->getStoreItem('guidOneName');

        $two = $returnData->getStoreItem('guidTwoName');

        self::assertEquals($guidOneString, $one->guid());

        self::assertEquals($guidTwoString, $two->guid());

        self::assertEquals('guidOneName', $one->name());

        self::assertEquals('guidTwoName', $two->name());

        self::assertEquals(['data' => 'thing'], $one->data());

        self::assertEquals([], $two->data());

        self::assertEquals($recordOneDate->format('Y-m-d H:i:s'), $one->addedAt()->format('Y-m-d H:i:s'));

        self::assertEquals($recordTwoDate->format('Y-m-d H:i:s'), $two->addedAt()->format('Y-m-d H:i:s'));
    }
}
