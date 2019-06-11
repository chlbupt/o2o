<?php

use think\migration\Migrator;
use think\migration\db\Column;

class User extends Migrator
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
        $table = $this->table('user', ['charset' => 'utf8', 'auto_incrment' => 1]);
        $table
            ->addColumn('username', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('password', 'string', ['limit' => 32, 'null' => false, 'default' => ''])
            ->addColumn('code', 'string', ['limit' => 10, 'null' => false, 'default' => ''])
            ->addColumn('last_login_ip', 'string', ['limit' => 20, 'null' => false, 'default' => ''])
            ->addColumn('last_login_time', 'integer', ['limit' => 11,'null' => false, 'default' => 0])
            ->addColumn('email', 'string', ['limit' => 32, 'null' => false, 'default' => ''])
            ->addColumn('mobile', 'string', ['limit' => 20,'null' => false, 'default' => ''])
            ->addColumn('listorder', 'integer', ['limit' => 8, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => 1, 'null' => false, 'default' => 0])
            ->addTimestamps()
            ->setPrimaryKey('id')
            ->setEngine('Innodb')
            ->addIndex('username', ['unique' => true])
            ->addIndex('email', ['unique' => true])
            ->create();
    }
}
