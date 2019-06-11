<?php

namespace app\admin\validate;

use think\Validate;

class Featured extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title' => 'require|max:10',
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
    protected $message = [];
    protected $scene = [
        'status' => ['id', 'status'],
    ];
}
