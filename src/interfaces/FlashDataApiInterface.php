<?php

declare(strict_types=1);

namespace corbomite\flashdata\interfaces;

use corbomite\flashdata\exceptions\InvalidFlashDataModelException;

interface FlashDataApiInterface
{
    /**
     * Creates a FlashDataModelInterface instance
     *
     * @param mixed[] $props
     */
    public function makeFlashDataModel(array $props = []) : FlashDataModelInterface;

    /**
     * Sets flash data for the current user
     *
     * @return mixed
     *
     * @throws InvalidFlashDataModelException
     */
    public function setFlashData(FlashDataModelInterface $model);

    /**
     * Gets flash data for the current user
     *
     * @param bool $clearData Clears all user flash data if true
     *
     * @return FlashDataModelInterface
     */
    public function getFlashData(bool $clearData = true) : FlashDataStoreModelInterface;
}
