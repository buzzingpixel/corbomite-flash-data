<?php

declare(strict_types=1);

namespace corbomite\tests\services\GetFlashDataService;

use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\PDO;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\GetFlashDataService;
use PHPUnit\Framework\TestCase;
use Throwable;

class NoKeyCookieTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $pdo = self::createMock(PDO::class);

        $cookieApi = self::createMock(CookieApiInterface::class);

        $cookieApi->expects(self::once())
            ->method('retrieveCookie')
            ->with(self::equalTo('flash_data_key'))
            ->willReturn(null);

        $ormFactory = self::createMock(Factory::class);

        $flashDataStoreModel = new FlashDataStoreModel();

        /** @noinspection PhpParamsInspection */
        $service = new GetFlashDataService($pdo, $cookieApi, $ormFactory, $flashDataStoreModel);

        $returnData = $service();

        self::assertSame($flashDataStoreModel, $returnData);

        self::assertEquals([], $returnData->store());
    }
}
