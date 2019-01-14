<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\db\PDO;
use Ramsey\Uuid\UuidFactory;
use buzzingpixel\cookieapi\CookieApi;
use corbomite\flashdata\FlashDataApi;
use corbomite\db\Factory as OrmFactory;
use corbomite\flashdata\models\FlashDataStoreModel;
use Symfony\Component\Console\Output\ConsoleOutput;
use corbomite\flashdata\services\SetFlashDataService;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\actions\CreateMigrationsAction;

return [
    CreateMigrationsAction::class => function () {
        return new CreateMigrationsAction(
            __DIR__ . '/migrations',
            new ConsoleOutput()
        );
    },
    FlashDataApi::class => function () {
        return new FlashDataApi(new Di());
    },
    SetFlashDataService::class => function () {
        return new SetFlashDataService(
            Di::get(PDO::class),
            Di::get(CookieApi::class),
            new OrmFactory(),
            new UuidFactory(),
            Di::get(FlashDataStoreModel::class)
        );
    },
    GetFlashDataService::class => function () {
        return new GetFlashDataService(
            Di::get(PDO::class),
            Di::get(CookieApi::class),
            new OrmFactory(),
            Di::get(FlashDataStoreModel::class)
        );
    },
    FlashDataStoreModel::class => function () {
        return new FlashDataStoreModel();
    },
];
