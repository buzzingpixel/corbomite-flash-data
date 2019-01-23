<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\models;

use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;

class FlashDataStoreModel implements FlashDataStoreModelInterface
{
    /** @var array|null */
    private $store;

    public function store(?array $store = null): ?array
    {
        if ($store !== null) {
            $this->store = $store;
        }

        return $this->store;
    }

    public function setStoreItem(FlashDataModelInterface $model): void
    {
        if ($this->store === null) {
            $this->store = [];
        }

        $this->store[$model->name()] = $model;
    }

    public function getStoreItem(string $name): ?FlashDataModelInterface
    {
        if ($this->store === null) {
            return null;
        }

        return $this->store[$name] ?? null;
    }
}
