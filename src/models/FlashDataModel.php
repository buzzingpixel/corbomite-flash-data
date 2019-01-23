<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\models;

use DateTime;
use corbomite\db\traits\UuidTrait;
use corbomite\flashdata\interfaces\FlashDataModelInterface;

class FlashDataModel implements FlashDataModelInterface
{
    use UuidTrait;

    public function __construct(array $props = [])
    {
        foreach ($props as $key => $val) {
            $this->{$key}($val);
        }
    }

    private $name = '';

    public function name(?string $name = null): string
    {
        return $this->name = $name ?? $this->name;
    }

    private $data = [];

    public function data(?array $data = null): array
    {
        return $this->data = $data ?? $this->data;
    }

    public function dataItem(string $key, $val = null)
    {
        if ($val !== null) {
            $this->data[$key] = $val;
        }

        return $this->data[$key] ?? null;
    }

    /** @var \DateTime|null */
    private $addedAt;

    public function addedAt(?DateTime $addedAt = null): ?DateTime
    {
        return $this->addedAt = $addedAt ?? $this->addedAt;
    }
}
