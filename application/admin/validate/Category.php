<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'name' => 'require|max:10',
        'parent_id' => 'number',
        'id' => 'number',
        'status' => 'integer|in:-1,0,1',
        'listorder' => 'number',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.require' => '分类名必须传递',
        'name.max' => '分类名不能超过10个字符',
        'status.number' => '状态必须是数字',
        'status.in' => '状态范围不合法',
    ];

    protected $scene = [
        'add' => ['name', 'parent_id', 'id'],
        'update' => ['id', 'name', 'parent_id'],
        'status' => ['id', 'status'],
    ];
}
