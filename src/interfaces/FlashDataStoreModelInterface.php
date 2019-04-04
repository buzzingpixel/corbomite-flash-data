<?php

declare(strict_types=1);

namespace corbomite\flashdata\interfaces;

interface FlashDataStoreModelInterface
{
    /**
     * Returns the value of store, sets store if there is an incoming array value
     * Returns null if no store has been set yet
     *
     * @param mixed[]|null $store
     *
     * @return mixed[]|null
     */
    public function store(?array $store = null) : ?array;

    /**
     * Sets an item to store on the store array.
     *
     * @return mixed
     */
    public function setStoreItem(FlashDataModelInterface $model);

    /**
     * Gets store item from the store array by name/key. Returns null if it does
     * not exist
     */
    public function getStoreItem(string $name) : ?FlashDataModelInterface;
}
