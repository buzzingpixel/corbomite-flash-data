<?php

declare(strict_types=1);

namespace corbomite\tests\actions\CreateMigrationsActionTest;

use corbomite\flashdata\actions\CreateMigrationsAction;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;

class PhinxPathConfInvalidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $srcDir = '/test/src/dir';

        $output = self::createMock(OutputInterface::class);

        $appBasePath = TESTS_BASE_PATH . '/actions/CreateMigrationsActionTest/TestFiles/PhinxPathConfInvalid';

        $fileSystem = self::createMock(Filesystem::class);

        $fileSystem->expects(self::once())
            ->method('exists')
            ->with(self::equalTo($appBasePath . '/phinx.php'))
            ->willReturn(true);

        /** @noinspection PhpParamsInspection */
        $createMigrationsAction = new CreateMigrationsAction($srcDir, $output, $appBasePath, $fileSystem);

        $exception = null;

        try {
            $createMigrationsAction();
        } catch (LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(LogicException::class, $exception);

        self::assertEquals('Migrations path could not be resolved', $exception->getMessage());
    }
}
