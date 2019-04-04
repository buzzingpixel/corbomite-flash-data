<?php

declare(strict_types=1);

namespace corbomite\flashdata\twigextensions;

use corbomite\flashdata\interfaces\FlashDataApiInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlashDataTwigExtension extends AbstractExtension
{
    /** @var FlashDataApiInterface */
    private $flashDataApi;

    public function __construct(FlashDataApiInterface $flashDataApi)
    {
        $this->flashDataApi = $flashDataApi;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions() : array
    {
        return [new TwigFunction('flashDataApi', [$this, 'flashDataApi'])];
    }

    public function flashDataApi() : FlashDataApiInterface
    {
        return $this->flashDataApi;
    }
}
