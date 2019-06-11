<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Bis extends Migrator
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
        $table = $this->table('bis', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('logo', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('licence_logo', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('city_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('city_path', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('bank_info', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('money', 'decimal', ['precision' => 20, 'scale' => 2, 'null' => false, 'default' => '0.00'])
            ->addColumn('bank_name', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('bank_user', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('faren', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('faren_tel', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('name')
            ->addIndex('city_id')
            ->create();
    }
}
