<?php
function bisStatus($status){
    switch($status){
        case 1:
            $msg = '入驻申请成功';
            break;
        case 0:
            $msg = '待审核，审核后平台方会发送邮件通知，请关注邮件';
            break;
        case 2:
            $msg = '非常抱歉，您提交的材料不符合条件，请重新提交';
            break;
        default:
            $msg = '该申请已被删除';
    }
    return $msg;
}
