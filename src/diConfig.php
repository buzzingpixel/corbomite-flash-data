<?php

declare(strict_types=1);

use buzzingpixel\cookieapi\CookieApi;
use Composer\Autoload\ClassLoader;
use corbomite\db\Factory as OrmFactory;
use corbomite\db\PDO;
use corbomite\flashdata\actions\CreateMigrationsAction;
use corbomite\flashdata\FlashDataApi;
use corbomite\flashdata\interfaces\FlashDataApiInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\models\FlashDataStoreModel;
use corbomite\flashdata\services\FlashDataGarbageCollectionService;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\services\SetFlashDataService;
use corbomite\flashdata\twigextensions\FlashDataTwigExtension;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\UuidFactory;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    FlashDataApiInterface::class => static function (ContainerInterface $di) {
        return $di->get(FlashDataApi::class);
    },
    CreateMigrationsAction::class => static function () {
        $appBasePath = null;

        if (defined('APP_BASE_PATH')) {
            $appBasePath = APP_BASE_PATH;
        }

        if (! $appBasePath) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $reflection = new ReflectionClass(ClassLoader::class);

            $appBasePath = dirname($reflection->getFileName(), 3);
        }

        return new CreateMigrationsAction(
            __DIR__ . '/migrations',
            new ConsoleOutput(),
            $appBasePath
        );
    },
    FlashDataApi::class => static function (ContainerInterface $di) {
        return new FlashDataApi($di);
    },
    SetFlashDataService::class => static function (ContainerInterface $di) {
        return new SetFlashDataService(
            $di->get(PDO::class),
            $di->get(CookieApi::class),
            new OrmFactory(),
            new UuidFactory(),
            $di->get(FlashDataStoreModel::class)
        );
    },
    GetFlashDataService::class => static function (ContainerInterface $di) {
        return new GetFlashDataService(
            $di->get(PDO::class),
            $di->get(CookieApi::class),
            new OrmFactory(),
            $di->get(FlashDataStoreModel::class)
        );
    },
    FlashDataStoreModelInterface::class => static function (ContainerInterface $di) {
        return $di->get(FlashDataStoreModel::class);
    },
    FlashDataStoreModel::class => static function () {
        return new FlashDataStoreModel();
    },
    FlashDataGarbageCollectionService::class => static function (ContainerInterface $di) {
        return new FlashDataGarbageCollectionService(
            $di->get(PDO::class)
        );
    },
    FlashDataTwigExtension::class => static function (ContainerInterface $di) {
        return new FlashDataTwigExtension(
            $di->get(FlashDataApi::class)
        );
    },
];
