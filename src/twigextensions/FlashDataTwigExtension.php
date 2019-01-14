<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\twigextensions;

use Twig_Function;
use Twig_Extension;
use corbomite\flashdata\interfaces\FlashDataApiInterface;

class FlashDataTwigExtension extends Twig_Extension
{
    private $flashDataApi;

    public function __construct(FlashDataApiInterface $flashDataApi)
    {
        $this->flashDataApi = $flashDataApi;
    }

    public function getFunctions(): array
    {
        return [new Twig_Function('flashDataApi', [$this, 'flashDataApi'])];
    }

    public function flashDataApi(): FlashDataApiInterface
    {
        return $this->flashDataApi;
    }
}
