<?php

declare(strict_types=1);

namespace corbomite\flashdata\models;

use corbomite\flashdata\interfaces\FlashDataModelInterface;
use DateTime;

class FlashDataModel implements FlashDataModelInterface
{
    /**
     * @param mixed[] $props
     */
    public function __construct(array $props = [])
    {
        foreach ($props as $key => $val) {
            $this->{$key}($val);
        }
    }

    /** @var string */
    private $guid = '';

    public function guid(?string $guid = null) : string
    {
        return $this->guid = $guid ?? $this->guid;
    }

    /** @var string */
    private $name = '';

    public function name(?string $name = null) : string
    {
        return $this->name = $name ?? $this->name;
    }

    /** @var mixed[] */
    private $data = [];

    /**
     * @param mixed[]|null $data
     *
     * @return mixed[]
     */
    public function data(?array $data = null) : array
    {
        return $this->data = $data ?? $this->data;
    }

    /**
     * @param mixed $val
     *
     * @return mixed
     */
    public function dataItem(string $key, $val = null)
    {
        if ($val !== null) {
            $this->data[$key] = $val;
        }

        return $this->data[$key] ?? null;
    }

    /** @var ?DateTime */
    private $addedAt;

    public function addedAt(?DateTime $addedAt = null) : ?DateTime
    {
        return $this->addedAt = $addedAt ?? $this->addedAt;
    }
}
