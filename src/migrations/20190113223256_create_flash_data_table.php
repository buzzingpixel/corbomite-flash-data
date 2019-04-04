<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateFlashDataTable extends AbstractMigration
{
    public function change() : void
    {
        $this->table('flash_data')
            ->addColumn('guid', 'string')
            ->addColumn('name', 'text', ['null' => true])
            ->addColumn('data', 'text', ['null' => true])
            ->addColumn('added_at', 'datetime', ['null' => true])
            ->addColumn('added_at_time_zone', 'string', ['null' => true])
            ->create();
    }
}
