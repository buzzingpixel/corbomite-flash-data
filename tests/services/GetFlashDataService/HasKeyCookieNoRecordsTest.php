<?php

declare(strict_types=1);

namespace corbomite\tests\services\GetFlashDataService;

use Atlas\Mapper\MapperSelect;
use buzzingpixel\cookieapi\Cookie;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\Orm;
use corbomite\db\PDO;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\GetFlashDataService;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Throwable;

class HasKeyCookieNoRecordsTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $q = self::createMock(PDOStatement::class);

        $q->expects(self::once())
            ->method('bindParam')
            ->with(self::equalTo(':guid'), self::equalTo('bar'));

        $q->expects(self::once())
            ->method('execute');

        $pdo = self::createMock(PDO::class);

        $pdo->expects(self::once())
            ->method('prepare')
            ->with(self::equalTo('DELETE FROM flash_data WHERE guid = :guid'))
            ->willReturn($q);

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
                self::equalTo('guid ='),
                self::equalTo('bar')
            )
            ->willReturn($mapperSelect);

        $mapperSelect->expects(self::once())
            ->method('fetchRecords')
            ->willReturn([]);

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

        /** @noinspection PhpParamsInspection */
        $service = new GetFlashDataService($pdo, $cookieApi, $ormFactory, $flashDataStoreModel);

        $returnData = $service();

        self::assertSame($flashDataStoreModel, $returnData);
    }
}
