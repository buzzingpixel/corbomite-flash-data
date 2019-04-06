<?php

declare(strict_types=1);

namespace corbomite\flashdata\interfaces;

use corbomite\db\interfaces\UuidModelInterface;
use DateTimeInterface;

interface FlashDataModelInterface
{
    /**
     * Sets incoming properties from the incoming array
     *
     * @param mixed[] $props
     */
    public function __construct(array $props = []);

    /**
     * Returns the value of guid, sets guid if there is an incoming string value
     */
    public function guid(?string $guid = null) : string;

    /**
     * Gets the UuidModel for the guid
     */
    public function guidAsModel() : UuidModelInterface;

    /**
     * Gets the GUID as bytes for saving to the database in binary
     */
    public function getGuidAsBytes() : string;

    /**
     * Sets the GUID from bytes coming from the database binary column
     *
     * @return mixed
     */
    public function setGuidAsBytes(string $bytes);

    /**
     * Returns the value of name, sets name if there is an incoming string value
     */
    public function name(?string $name = null) : string;

    /**
     * Returns the value of data, sets data if there is an incoming array value
     *
     * @param mixed[]|null $data
     *
     * @return mixed[]
     */
    public function data(?array $data = null) : array;

    /**
     * Returns the value from the specified key in the data array if that key
     * exists, sets it if there is a specified incoming value
     *
     * @param mixed $val
     *
     * @return mixed
     */
    public function dataItem(string $key, $val = null);

    /**
     * Returns the value of addedAt, sets the value if there is an incoming
     * DateTimeInterface
     */
    public function addedAt(?DateTimeInterface $addedAt = null) : ?DateTimeInterface;
}
