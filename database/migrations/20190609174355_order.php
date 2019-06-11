<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Order extends Migrator
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
        $table = $this->table('order', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('out_trade_no', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('transation_id', 'string', ['limit' => 100,'null' => false, 'default' => ''])
            ->addColumn('user_id', 'integer', ['limit' => 11,'null' => false, 'default' =>0])
            ->addColumn('username', 'string', ['limit' => 50,'null' => false, 'default' => ''])
            ->addColumn('pay_time', 'string', ['limit' => 200,'null' => false, 'default' => ''])
            ->addColumn('payment_id', 'integer', ['limit' => 11,'null' => false, 'default' => 1])
            ->addColumn('deal_id', 'integer', ['limit' => 11,'null' => false, 'default' =>0])
            ->addColumn('deal_count', 'integer', ['limit' => 11,'null' => false, 'default' =>0])
            ->addColumn('deal_time', 'integer', ['limit' => 11,'null' => false, 'default' =>0])
            ->addColumn('pay_status', 'integer', ['limit' => 11,'null' => false, 'default' => 0, 'comment' => '支付状态 0:未支付 1:支付成功 2:支付失败 3:其他'])

            ->addColumn('total_price', 'decimal', ['precision' => 20, 'scale' => 2, 'null' => false, 'default' => '0.00'])
            ->addColumn('pay_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'null' => false, 'default' => '0.00'])
            ->addColumn('referer', 'string', ['limit' => 255,'null' => false, 'default' => ''])

            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 1])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('out_trade_no', ['unique' => true])
            ->addIndex('user_id')
            ->addIndex('create_time')
            ->create();
    }
}
