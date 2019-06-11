<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Area extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('area', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('city_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('parent_id', 'integer', ['limit' => 10, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('parent_id')
            ->addIndex('city_id')
            ->create();
    }
}
