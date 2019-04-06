<?php

declare(strict_types=1);

namespace corbomite\tests\services\SetFlashDataServiceTest;

use buzzingpixel\cookieapi\Cookie;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\Orm;
use corbomite\db\PDO;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\data\FlashDatum\FlashDatumRecord;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\services\SetFlashDataService;
use DateTime;
use DateTimeZone;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactoryInterface;
use Throwable;

class SaveKeyCookieTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $q = self::createMock(PDOStatement::class);

        $q->expects(self::at(0))
            ->method('bindParam')
            ->with(self::equalTo(':guid'), self::equalTo('TestCookieValue'));

        $q->expects(self::at(1))
            ->method('bindParam')
            ->with(self::equalTo(':name'), self::equalTo('TestModelName'));

        $q->expects(self::at(2))
            ->method('execute');

        $pdo = self::createMock(PDO::class);

        $pdo->expects(self::at(0))
            ->method('prepare')
            ->with(self::equalTo('DELETE FROM flash_data WHERE guid = :guid AND name = :name'))
            ->willReturn($q);

        $keyCookie = new Cookie('flash_data_key', 'TestCookieValue');

        $cookieApi = self::createMock(CookieApiInterface::class);

        $cookieApi->expects(self::once())
            ->method('retrieveCookie')
            ->with(self::equalTo('flash_data_key'))
            ->willReturn($keyCookie);

        $record = self::createMock(FlashDatumRecord::class);

        $record->expects(self::at(0))
            ->method('__set')
            ->with(self::equalTo('guid'), self::equalTo('TestCookieValue'));

        $record->expects(self::at(1))
            ->method('__set')
            ->with(self::equalTo('name'), self::equalTo('TestModelName'));

        $record->expects(self::at(2))
            ->method('__set')
            ->with(self::equalTo('data'), self::equalTo('{"foo":"bar"}'));

        $date = new DateTime('now', new DateTimeZone('UTC'));

        $record->expects(self::at(3))
            ->method('__set')
            ->with(self::equalTo('added_at'), self::equalTo($date->format('Y-m-d H:i:s')));

        $record->expects(self::at(4))
            ->method('__set')
            ->with(self::equalTo('added_at_time_zone'), self::equalTo('UTC'));

        $orm = self::createMock(Orm::class);

        $orm->expects(self::at(0))
            ->method('newRecord')
            ->with(self::equalTo(FlashDatum::class))
            ->willReturn($record);

        $orm->expects(self::at(1))
            ->method('persist')
            ->with(self::equalTo($record));

        $ormFactory = self::createMock(Factory::class);

        $ormFactory->expects(self::at(0))
            ->method('makeOrm')
            ->willReturn($orm);

        $uuidFactory = self::createMock(UuidFactoryInterface::class);

        $model = self::createMock(FlashDataModelInterface::class);

        $model->method('name')->willReturn('TestModelName');

        $model->method('data')->willReturn(['foo' => 'bar']);

        $flashDataStoreModel = self::createMock(FlashDataStoreModelInterface::class);

        $flashDataStoreModel->expects(self::at(0))
            ->method('setStoreItem')
            ->with(self::equalTo($model));

        /** @noinspection PhpParamsInspection */
        $service = new SetFlashDataService(
            $pdo,
            $cookieApi,
            $ormFactory,
            $uuidFactory,
            $flashDataStoreModel
        );

        /** @noinspection PhpParamsInspection */
        $service($model);
    }
}
