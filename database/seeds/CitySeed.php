<?php

use think\migration\Seeder;

class CitySeed extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function fake(){
        return [
            ['name' => '北京', 'uname' => 'beijing1', 'parent_id' => 0, 'is_default' => 0, 'status' => 1],
            ['name' => '北京', 'uname' => 'beijing', 'parent_id' => 1, 'is_default' => 0, 'status' => 1],
            ['name' => '江西', 'uname' => 'jiangxi', 'parent_id' => 0, 'is_default' => 0, 'status' => 1],
            ['name' => '南昌', 'uname' => 'nanchang', 'parent_id' => 3, 'is_default' => 1, 'status' => 1],
            ['name' => '上饶', 'uname' => 'shangrao', 'parent_id' => 3, 'is_default' => 0, 'status' => 1],
            ['name' => '抚州', 'uname' => 'fuzhou', 'parent_id' => 3, 'is_default' => 0, 'status' => 1],
            ['name' => '景德镇', 'uname' => 'jdz', 'parent_id' => 3, 'is_default' => 0, 'status' => 1],
        ];
    }
    public function run()
    {
        $citys = $this->fake();
        foreach($citys as $city){
            db('city')->insert($city);
        }
    }
}