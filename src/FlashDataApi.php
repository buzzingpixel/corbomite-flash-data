<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata;

use corbomite\di\Di;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\services\SetFlashData;
use corbomite\flashdata\interfaces\FlashDataApiInterface;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\exceptions\InvalidFlashDataModelException;

class FlashDataApi implements FlashDataApiInterface
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    public function makeFlashDataModel(array $props = []): FlashDataModelInterface
    {
        return new FlashDataModel($props);
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function setFlashData(FlashDataModelInterface $model): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->di->getFromDefinition(SetFlashData::class)->set($model);
    }
}
