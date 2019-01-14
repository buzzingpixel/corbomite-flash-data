<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\interfaces;

use corbomite\flashdata\exceptions\InvalidFlashDataModelException;

interface FlashDataApiInterface
{
    /**
     * Creates a FlashDataModelInterface instance
     * @param array $props
     * @return FlashDataModelInterface
     */
    public function makeFlashDataModel(array $props = []): FlashDataModelInterface;

    /**
     * Sets flash data for the current user
     * @param FlashDataModelInterface $model
     * @throws InvalidFlashDataModelException
     */
    public function setFlashData(FlashDataModelInterface $model);

    /**
     * Gets flash data for the current user
     * @param bool $clearData Clears all user flash data if true
     * @return FlashDataModelInterface[]
     */
    public function getFlashData(bool $clearData = true): FlashDataStoreModelInterface;
}
