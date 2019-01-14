<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\interfaces;

interface FlashDataStoreModelInterface
{
    /**
     * Returns the value of store, sets store if there is an incoming array value
     * Returns null if no store has been set yet
     * @param array|null $store
     * @return array|null
     */
    public function store(?array $store = null): ?array;

    /**
     * Sets an item to store on the store array.
     * @param FlashDataModelInterface $model
     */
    public function setStoreItem(FlashDataModelInterface $model);

    /**
     * Gets store item from the store array by name/key. Returns null if it does
     * not exist
     * @param string $name
     * @return FlashDataModelInterface|null
     */
    public function getStoreItem(string $name): ?FlashDataModelInterface;
}
