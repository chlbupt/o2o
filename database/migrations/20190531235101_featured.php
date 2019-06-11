<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Featured extends Migrator
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
        $table = $this->table('featured', ['charset' => 'utf8', 'auto_incrment' => 1, 'comment' => '商品推荐位表']);
        $table
            ->addColumn('type', 'integer', ['limit' => 1,'null' => false, 'default' => 0])
            ->addColumn('title', 'string', ['limit' => 30, 'null' => false, 'default' => ''])
            ->addColumn('image', 'string', ['limit' => 255,'null' => false, 'default' => ''])
            ->addColumn('url', 'string', ['limit' => 255,'null' => false, 'default' => ''])
            ->addColumn('description', 'string', ['limit' => 255,'null' => false, 'default' => ''])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->create();
    }
}
