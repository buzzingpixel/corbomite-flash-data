<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\models;

use DateTime;

class FlashDataModel
{
    public function __construct(array $props = [])
    {
        foreach ($props as $key => $val) {
            $this->{$key}($val);
        }
    }

    private $guid = '';

    public function guid(?string $guid = null): string
    {
        return $this->guid = $guid !== null ? $guid : $this->guid;
    }

    private $name = '';

    public function name(?string $name = null): string
    {
        return $this->name = $name !== null ? $name : $this->name;
    }

    private $data = [];

    public function data(?array $data = null): array
    {
        return $this->data = $data !== null ? $data : $this->data;
    }

    public function dataItem(string $key, $val = null)
    {
        if ($val !== null) {
            $this->data[$key] = $val;
        }

        return $this->data[$key] ?? null;
    }

    private $addedAt;

    public function addedAt(?DateTime $addedAt = null): ?DateTime
    {
        return $this->addedAt = $addedAt !== null ? $addedAt : $this->addedAt;
    }
}
