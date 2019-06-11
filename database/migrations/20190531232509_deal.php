<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Deal extends Migrator
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
        $table = $this->table('deal', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('category_id', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('se_category_id', 'string', ['limit' => 255,'null' => false, 'default' => 0])
            ->addColumn('bis_id', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('location_ids', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('image', 'string', ['limit' => 200, 'null' => false, 'default' => ''])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('start_time', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('end_time', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('origin_price', 'decimal', ['precision' => 20, 'scale' => 2, 'null' => false, 'default' => '0.00'])
            ->addColumn('current_price', 'decimal', ['precision' => 20, 'scale' => 2,'null' => false, 'default' => '0.00'])
            ->addColumn('city_id', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('buy_count', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('total_count', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('coupons_start_time', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('coupons_end_time', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('xpoint', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('ypoint', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('bis_account_id', 'integer', ['limit' => 10,'null' => false, 'default' => 0])
            ->addColumn('balance_price', 'decimal', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('notes', 'text', ['null' => false])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('category_id')
            ->addIndex('se_category_id')
            ->addIndex('city_id')
            ->addIndex('start_time')
            ->addIndex('end_time')
            ->create();
    }
}
