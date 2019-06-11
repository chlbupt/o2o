<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Coupons extends Migrator
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
        $table = $this->table('coupon', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table->addColumn('sn', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('password', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('deal_id', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('order_id', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '0:已生成未发送 1:已发送 2:已使用 3:禁用'])
            ->addTimestamps()
//            ->addIndex('sn', ['unique' => true])
            ->addIndex('user_id')
            ->addIndex('deal_id')
            ->addIndex('create_time')
            ->create();
    }
}
