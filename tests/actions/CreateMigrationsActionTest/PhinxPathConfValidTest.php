<?php

declare(strict_types=1);

namespace corbomite\tests\actions\CreateMigrationsActionTest;

use corbomite\flashdata\actions\CreateMigrationsAction;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;

class PhinxPathConfValidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $srcDir = TESTS_BASE_PATH . '/actions/CreateMigrationsActionTest/TestFiles/TestMigrationFiles';

        $appBasePath = TESTS_BASE_PATH . '/actions/CreateMigrationsActionTest/TestFiles/PhinxPathConfValid';

        $output = self::createMock(OutputInterface::class);

        $output->expects(self::at(0))
            ->method('writeln')
            ->with(
                self::equalTo(
                    '<fg=green>MigFileOne.php already exists.</>'
                )
            );

        $output->expects(self::at(1))
            ->method('writeln')
            ->with(
                self::equalTo(
                    '<fg=green>MigFileTwo.php created.</>'
                )
            );

        $fileSystem = self::createMock(Filesystem::class);

        $fileSystem->expects(self::at(0))
            ->method('exists')
            ->with(self::equalTo($appBasePath . '/phinx.php'))
            ->willReturn(true);

        $fileSystem->expects(self::at(1))
            ->method('exists')
            ->with(self::equalTo($appBasePath . '/migrations/MigFileOne.php'))
            ->willReturn(true);

        $fileSystem->expects(self::at(2))
            ->method('exists')
            ->with(self::equalTo($appBasePath . '/migrations/MigFileTwo.php'))
            ->willReturn(false);

        $fileSystem->expects(self::at(3))
            ->method('copy')
            ->with(
                self::equalTo($srcDir . '/MigFileTwo.php'),
                self::equalTo($appBasePath . '/migrations/MigFileTwo.php')
            );

        /** @noinspection PhpParamsInspection */
        $createMigrationsAction = new CreateMigrationsAction($srcDir, $output, $appBasePath, $fileSystem);

        $createMigrationsAction();
    }
}
