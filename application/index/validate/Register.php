<?php

namespace app\index\validate;

use think\Validate;

class Register extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'username|用户名' => 'require|min:5',
        'email|邮箱' => 'require|email',
        'password|密码' => 'require|min:6|max:10|confirm',
        'verifyCode|验证码' => 'require'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'register' => ['username', 'email', 'password', 'verifyCode'],
    ];
}
