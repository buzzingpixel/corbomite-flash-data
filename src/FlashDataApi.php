<?php

declare(strict_types=1);

namespace corbomite\flashdata;

use corbomite\di\Di;
use corbomite\flashdata\exceptions\InvalidFlashDataModelException;
use corbomite\flashdata\interfaces\FlashDataApiInterface;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\services\SetFlashDataService;

class FlashDataApi implements FlashDataApiInterface
{
    /** @var Di */
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @param mixed[] $props
     */
    public function makeFlashDataModel(array $props = []) : FlashDataModelInterface
    {
        return new FlashDataModel($props);
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function setFlashData(FlashDataModelInterface $model) : void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->di->getFromDefinition(SetFlashDataService::class)->set($model);
    }

    public function getFlashData(bool $clearData = true) : FlashDataStoreModelInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->di->getFromDefinition(GetFlashDataService::class)->get(
            $clearData
        );
    }
}
