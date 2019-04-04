<?php

declare(strict_types=1);

namespace corbomite\flashdata\actions;

use DirectoryIterator;
use LogicException;
use RegexIterator;
use Symfony\Component\Console\Output\OutputInterface;
use function copy;
use function file_exists;
use function realpath;
use function str_replace;

class CreateMigrationsAction
{
    /** @var string */
    private $srcDir;
    /** @var OutputInterface */
    private $output;
    /** @var string $appBasePath */
    private $appBasePath;

    public function __construct(string $srcDir, OutputInterface $output, string $appBasePath)
    {
        $this->srcDir      = $srcDir;
        $this->output      = $output;
        $this->appBasePath = $appBasePath;
    }

    public function __invoke() : void
    {
        if (! file_exists($this->appBasePath . '/phinx.php')) {
            throw new LogicException('phinx.php must be present in your project');
        }

        $phinxConf = include $this->appBasePath . '/phinx.php';
        $dest      = $phinxConf['paths']['migrations'] ?? null;

        if (! $dest) {
            throw new LogicException('Migrations path must be defined in phinx conf');
        }

        $dest = realpath(
            str_replace('%%PHINX_CONFIG_DIR%%', $this->appBasePath, $dest)
        );

        if (! $dest) {
            throw new LogicException('Migrations path could not be resolved');
        }

        $iterator = new RegexIterator(
            new DirectoryIterator($this->srcDir),
            '/^.+\.php$/i',
            RegexIterator::GET_MATCH
        );

        foreach ($iterator as $files) {
            foreach ($files as $file) {
                $path     = $this->srcDir . '/' . $file;
                $destPath = $dest . '/' . $file;

                if (file_exists($destPath)) {
                    $this->output->writeln(
                        '<fg=green>' . $file . ' already exists.</>'
                    );

                    continue;
                }

                copy($path, $destPath);

                $this->output->writeln(
                    '<fg=green>' . $file . ' created.</>'
                );
            }
        }
    }
}
