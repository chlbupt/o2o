<?php

use think\migration\Migrator;
use think\migration\db\Column;

class BisLocation extends Migrator
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
        $table = $this->table('bis_location', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('address', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('tel', 'string', ['limit' => 20,'null' => false, 'default' => ''])
            ->addColumn('contact', 'string', ['limit' => 20,'null' => false, 'default' => ''])
            ->addColumn('xpoint', 'string', ['limit' => 20,'null' => false, 'default' => ''])
            ->addColumn('ypoint', 'string', ['limit' => 20,'null' => false, 'default' => ''])
            ->addColumn('bis_id', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('open_time', 'string', ['limit' => 100,'null' => false, 'default' => 0])
            ->addColumn('content', 'text', ['null' => false])
            ->addColumn('is_main', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('api_address', 'string', ['limit' => 255,'null' => false, 'default' => ''])
            ->addColumn('city_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('city_path', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('category_id', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('category_path', 'string', ['limit' => 255,'null' => false, 'default' => 0])
            ->addColumn('bank_info', 'string', ['limit' => 50, 'null' => false, 'default' => ''])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('name')
            ->addIndex('city_id')
            ->addIndex('bis_id')
            ->addIndex('category_id')
            ->create();
    }
}
