<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

/**
 * This file is for testing purposes only
 */

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

define('APP_BASE_PATH', dirname(__DIR__));

require_once APP_BASE_PATH . '/vendor/autoload.php';

putenv('ENCRYPTION_KEY=1234567890qwertyuiopasdfghjklzxc');
putenv('DB_HOST=db');
putenv('DB_DATABASE=site');
putenv('DB_USER=site');
putenv('DB_PASSWORD=secret');

use corbomite\flashdata\FlashDataApi;

/** @noinspection PhpUnhandledExceptionInspection */
$flashDataApi = Di::get(FlashDataApi::class);

$model = $flashDataApi->makeFlashDataModel([
    'name' => 'test_flash_data_key',
]);
$model->dataItem('myItem', 'myVal');

$flashDataApi->setFlashData($model);
