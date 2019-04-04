<?php

declare(strict_types=1);

namespace corbomite\flashdata\actions;

use DirectoryIterator;
use LogicException;
use RegexIterator;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
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
    /** @var Filesystem */
    private $filesystem;

    public function __construct(string $srcDir, OutputInterface $output, string $appBasePath, Filesystem $filesystem)
    {
        $this->srcDir      = $srcDir;
        $this->output      = $output;
        $this->appBasePath = $appBasePath;
        $this->filesystem  = $filesystem;
    }

    public function __invoke() : void
    {
        $phinxPhpFile = $this->appBasePath . '/phinx.php';

        if (! $this->filesystem->exists($phinxPhpFile)) {
            throw new LogicException('phinx.php must be present in your project');
        }

        $phinxConf = include $this->appBasePath . '/phinx.php';

        $dest = $phinxConf['paths']['migrations'] ?? null;

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
                $path = $this->srcDir . '/' . $file;

                $destPath = $dest . '/' . $file;

                if ($this->filesystem->exists($destPath)) {
                    $this->output->writeln(
                        '<fg=green>' . $file . ' already exists.</>'
                    );

                    continue;
                }

                $this->filesystem->copy($path, $destPath);

                $this->output->writeln(
                    '<fg=green>' . $file . ' created.</>'
                );
            }
        }
    }
}
