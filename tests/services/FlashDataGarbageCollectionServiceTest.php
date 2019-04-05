<?php

declare(strict_types=1);

namespace corbomite\tests\services;

use corbomite\db\PDO;
use corbomite\flashdata\services\FlashDataGarbageCollectionService;
use DateTime;
use DateTimeZone;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Throwable;
use function strtotime;

class FlashDataGarbageCollectionServiceTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp(strtotime('2 minutes ago'));
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $q = self::createMock(PDOStatement::class);

        $q->expects(self::once())
            ->method('execute')
            ->with(self::equalTo([$dateTime->format('Y-m-d H:i:s')]));

        $pdo = self::createMock(PDO::class);

        $pdo->expects(self::once())
            ->method('prepare')
            ->with(self::equalTo('DELETE FROM flash_data WHERE added_at < ?'))
            ->willReturn($q);

        /** @noinspection PhpParamsInspection */
        $service = new FlashDataGarbageCollectionService($pdo);

        $service();
    }
}
