<?php

declare(strict_types=1);

namespace corbomite\tests\services\SetFlashDataServiceTest;

use buzzingpixel\cookieapi\Cookie;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory;
use corbomite\db\PDO;
use corbomite\flashdata\exceptions\InvalidFlashDataModelException;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\services\SetFlashDataService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactoryInterface;
use Throwable;

class KeyCookieNoModelNameTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $pdo = self::createMock(PDO::class);

        $keyCookie = new Cookie('flash_data_key', 'TestCookieValue');

        $cookieApi = self::createMock(CookieApiInterface::class);

        $cookieApi->expects(self::once())
            ->method('retrieveCookie')
            ->with(self::equalTo('flash_data_key'))
            ->willReturn($keyCookie);

        $ormFactory = self::createMock(Factory::class);

        $uuidFactory = self::createMock(UuidFactoryInterface::class);

        $flashDataStoreModel = self::createMock(FlashDataStoreModelInterface::class);

        $model = self::createMock(FlashDataModelInterface::class);

        $model->expects(self::once())
            ->method('name')
            ->willReturn('');

        /** @noinspection PhpParamsInspection */
        $service = new SetFlashDataService(
            $pdo,
            $cookieApi,
            $ormFactory,
            $uuidFactory,
            $flashDataStoreModel
        );

        $exception = null;

        try {
            /** @noinspection PhpParamsInspection */
            $service($model);
        } catch (InvalidFlashDataModelException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(InvalidFlashDataModelException::class, $exception);

        self::assertEquals('The FlashDataModel is invalid', $exception->getMessage());
    }
}
