<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3
 * Time: 2:26
 */

namespace app\extend\phpmailer;


class Email
{
    public static function send($to, $subject, $content)
    {
        if(!$to) return false;
        try{
            date_default_timezone_set('PRC');//set time
            $mail = new PHPMailer;
            $mail->isSMTP();
//            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';
            $mail->Host = config('email.host');
            $mail->Port = config('email.port');
            $mail->SMTPAuth = true;
            $mail->Username = config('email.username');
            $mail->Password = config('email.password');
            $mail->setFrom(config('email.username'), 'TP5.1');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->msgHTML($content);
            if (!$mail->send()) {
                return 'fa 1';
            } else {
                return true;
            }
        }catch(phpmailerException $e){
            return false;
        }
    }
}