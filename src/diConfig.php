<?php

declare(strict_types=1);

use buzzingpixel\cookieapi\CookieApi;
use corbomite\db\Factory as OrmFactory;
use corbomite\db\PDO;
use corbomite\di\Di;
use corbomite\flashdata\actions\CreateMigrationsAction;
use corbomite\flashdata\FlashDataApi;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\FlashDataGarbageCollectionService;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\services\SetFlashDataService;
use corbomite\flashdata\twigextensions\FlashDataTwigExtension;
use Ramsey\Uuid\UuidFactory;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    CreateMigrationsAction::class => static function () {
        return new CreateMigrationsAction(
            __DIR__ . '/migrations',
            new ConsoleOutput()
        );
    },
    FlashDataApi::class => static function () {
        return new FlashDataApi(new Di());
    },
    SetFlashDataService::class => static function () {
        return new SetFlashDataService(
            Di::get(PDO::class),
            Di::get(CookieApi::class),
            new OrmFactory(),
            new UuidFactory(),
            Di::get(FlashDataStoreModel::class)
        );
    },
    GetFlashDataService::class => static function () {
        return new GetFlashDataService(
            Di::get(PDO::class),
            Di::get(CookieApi::class),
            new OrmFactory(),
            Di::get(FlashDataStoreModel::class)
        );
    },
    FlashDataStoreModel::class => static function () {
        return new FlashDataStoreModel();
    },
    FlashDataGarbageCollectionService::class => static function () {
        return new FlashDataGarbageCollectionService(Di::get(PDO::class));
    },
    FlashDataTwigExtension::class => static function () {
        return new FlashDataTwigExtension(Di::get(FlashDataApi::class));
    },
];
