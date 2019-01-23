<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\interfaces;

use DateTime;
use corbomite\db\interfaces\UuidModelInterface;

interface FlashDataModelInterface
{
    /**
     * Sets incoming properties from the incoming array
     * @param array $props
     */
    public function __construct(array $props = []);

    /**
     * Returns the value of guid, sets guid if there is an incoming string value
     * @param string|null $guid
     * @return string
     */
    public function guid(?string $guid = null): string;

    /**
     * Gets the UuidModel for the guid
     * @return UuidModelInterface
     */
    public function guidAsModel(): UuidModelInterface;

    /**
     * Gets the GUID as bytes for saving to the database in binary
     * @return string
     */
    public function getGuidAsBytes(): string;

    /**
     * Sets the GUID from bytes coming from the database binary column
     * @param string $bytes
     */
    public function setGuidAsBytes(string $bytes);

    /**
     * Returns the value of name, sets name if there is an incoming string value
     * @param string|null $name
     * @return string
     */
    public function name(?string $name = null): string;

    /**
     * Returns the value of data, sets data if there is an incoming array value
     * @param array|null $data
     * @return array
     */
    public function data(?array $data = null): array;

    /**
     * Returns the value from the specified key in the data array if that key
     * exists, sets it if there is a specified incoming value
     * @param string $key
     * @param null $val
     * @return mixed
     */
    public function dataItem(string $key, $val = null);

    /**
     * Returns the value of addedAt, sets the value if there is an incoming
     * DateTime object
     * @param DateTime|null $addedAt
     * @return DateTime|null
     */
    public function addedAt(?DateTime $addedAt = null): ?DateTime;
}
