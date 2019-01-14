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
use corbomite\flashdata\services\SetFlashData;
use Symfony\Component\Console\Output\ConsoleOutput;
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
    SetFlashData::class => function () {
        return new SetFlashData(
            Di::get(PDO::class),
            Di::get(CookieApi::class),
            new OrmFactory(),
            new UuidFactory()
        );
    },
];
