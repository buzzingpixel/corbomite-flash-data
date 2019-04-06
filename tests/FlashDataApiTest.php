<?php

declare(strict_types=1);

namespace corbomite\tests;

use corbomite\flashdata\FlashDataApi;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\services\SetFlashDataService;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Throwable;

class FlashDataApiTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testMakeFlashDataModel() : void
    {
        $di = self::createMock(ContainerInterface::class);

        /** @noinspection PhpParamsInspection */
        $flashDataApi = new FlashDataApi($di);

        self::assertInstanceOf(FlashDataModel::class, $flashDataApi->makeFlashDataModel());
    }

    /**
     * @throws Throwable
     */
    public function testSetFlashData() : void
    {
        $model = self::createMock(FlashDataModelInterface::class);

        $setFlashDataService = self::createMock(SetFlashDataService::class);

        $setFlashDataService->expects(self::once())
            ->method('set')
            ->with(self::equalTo($model));

        $di = self::createMock(ContainerInterface::class);

        $di->expects(self::once())
            ->method('get')
            ->willReturn($setFlashDataService);

        /** @noinspection PhpParamsInspection */
        $flashDataApi = new FlashDataApi($di);

        /** @noinspection PhpParamsInspection */
        $flashDataApi->setFlashData($model);
    }

    /**
     * @throws Throwable
     */
    public function testGetFlashDataWithFalseClearData() : void
    {
        $getFlashDataService = self::createMock(GetFlashDataService::class);

        $getFlashDataService->expects(self::once())
            ->method('get')
            ->with(self::equalTo(false));

        $di = self::createMock(ContainerInterface::class);

        $di->expects(self::once())
            ->method('get')
            ->willReturn($getFlashDataService);

        /** @noinspection PhpParamsInspection */
        $flashDataApi = new FlashDataApi($di);

        $flashDataApi->getFlashData(false);
    }

    /**
     * @throws Throwable
     */
    public function testGetFlashDataWithClearData() : void
    {
        $getFlashDataService = self::createMock(GetFlashDataService::class);

        $getFlashDataService->expects(self::once())
            ->method('get')
            ->with(self::equalTo(true));

        $di = self::createMock(ContainerInterface::class);

        $di->expects(self::once())
            ->method('get')
            ->willReturn($getFlashDataService);

        /** @noinspection PhpParamsInspection */
        $flashDataApi = new FlashDataApi($di);

        $flashDataApi->getFlashData();
    }
}
