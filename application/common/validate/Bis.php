<?php

namespace app\common\validate;

use think\Validate;

class Bis extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'name' => 'require|max:25',
	    'email' => 'require|email',
	    'logo' => 'require',
	    'city_id' => 'require',
	    'bank_info' => 'require',
	    'bank_name' => 'require',
	    'bank_user' => 'require',
	    'faren' => 'require',
	    'faren_tel' => 'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [

    ];

    protected $scene = [
        'add' => ['name', 'email', 'logo', 'city_id', 'bank_info', 'bank_name', 'bank_user', 'faren', 'faren_tel'],
    ];
}
