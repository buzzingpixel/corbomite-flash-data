<?php

declare(strict_types=1);

namespace corbomite\tests\services\GetFlashDataService;

use buzzingpixel\cookieapi\Cookie;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\PDO;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\GetFlashDataService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactory;
use Throwable;

class HasKeyCookieStoreNotNullTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $pdo = self::createMock(PDO::class);

        $keyCookie = new Cookie('foo', 'bar');

        $cookieApi = self::createMock(CookieApiInterface::class);

        $cookieApi->expects(self::once())
            ->method('retrieveCookie')
            ->with(self::equalTo('flash_data_key'))
            ->willReturn($keyCookie);

        $ormFactory = self::createMock(Factory::class);

        $testFlashDataModel = new FlashDataModel(['name' => 'baz']);

        $flashDataStoreModel = new FlashDataStoreModel();

        $flashDataStoreModel->setStoreItem($testFlashDataModel);

        $uuidFactory = self::createMock(UuidFactory::class);

        /** @noinspection PhpParamsInspection */
        $service = new GetFlashDataService(
            $pdo,
            $ormFactory,
            $cookieApi,
            $uuidFactory,
            $flashDataStoreModel
        );

        $returnData = $service();

        self::assertSame($flashDataStoreModel, $returnData);

        self::assertEquals(['baz' => $testFlashDataModel], $returnData->store());
    }
}
