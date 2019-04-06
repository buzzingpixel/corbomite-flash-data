<?php

declare(strict_types=1);

namespace corbomite\tests\twigextensions;

use corbomite\flashdata\interfaces\FlashDataApiInterface;
use corbomite\flashdata\twigextensions\FlashDataTwigExtension;
use PHPUnit\Framework\TestCase;
use Throwable;

class FlashDataTwigExtensionTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $flashDataApi = self::createMock(FlashDataApiInterface::class);

        /** @noinspection PhpParamsInspection */
        $twigExtension = new FlashDataTwigExtension($flashDataApi);

        $twigExtensions = $twigExtension->getFunctions();

        self::assertIsArray($twigExtensions);

        self::assertCount(1, $twigExtensions);

        $ext = $twigExtensions[0];

        self::assertEquals('flashDataApi', $ext->getName());

        self::assertInstanceOf(FlashDataTwigExtension::class, $ext->getCallable()[0]);

        self::assertEquals('flashDataApi', $ext->getCallable()[1]);

        self::assertSame($flashDataApi, $twigExtension->flashDataApi());
    }
}
