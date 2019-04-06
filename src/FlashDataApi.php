<?php

declare(strict_types=1);

namespace corbomite\flashdata;

use corbomite\flashdata\exceptions\InvalidFlashDataModelException;
use corbomite\flashdata\interfaces\FlashDataApiInterface;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\services\GetFlashDataService;
use corbomite\flashdata\services\SetFlashDataService;
use Psr\Container\ContainerInterface;

class FlashDataApi implements FlashDataApiInterface
{
    /** @var ContainerInterface */
    private $di;

    public function __construct(ContainerInterface $di)
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
        $this->di->get(SetFlashDataService::class)->set($model);
    }

    public function getFlashData(bool $clearData = true) : FlashDataStoreModelInterface
    {
        return $this->di->get(GetFlashDataService::class)->get(
            $clearData
        );
    }
}
