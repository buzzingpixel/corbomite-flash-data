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
    public function makeFlashDataModel(array $props = []): FlashDataModelInterface;

    /**
     * @throws InvalidFlashDataModelException
     */
    public function setFlashData(FlashDataModelInterface $model);
}
