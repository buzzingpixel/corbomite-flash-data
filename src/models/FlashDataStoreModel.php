<?php

declare(strict_types=1);

namespace corbomite\flashdata\models;

use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use InvalidArgumentException;

class FlashDataStoreModel implements FlashDataStoreModelInterface
{
    /** @var FlashDataModelInterface[]|null */
    private $store;

    /**
     * @param FlashDataModelInterface[]|null $store
     *
     * @return FlashDataModelInterface[]|null
     */
    public function store(?array $store = null) : ?array
    {
        if ($store !== null) {
            foreach ($store as $item) {
                $isInstance = $item instanceof FlashDataModelInterface;

                if (! $isInstance) {
                    throw new InvalidArgumentException(
                        '$store must be an array of FlashDataModelInterface'
                    );
                }
            }

            $this->store = $store;
        }

        return $this->store;
    }

    public function setStoreItem(FlashDataModelInterface $model) : void
    {
        if ($this->store === null) {
            $this->store = [];
        }

        $this->store[$model->name()] = $model;
    }

    public function getStoreItem(string $name) : ?FlashDataModelInterface
    {
        if ($this->store === null) {
            return null;
        }

        return $this->store[$name] ?? null;
    }
}
