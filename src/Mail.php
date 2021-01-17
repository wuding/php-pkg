<?php

namespace Pkg;

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mail
{
    public static $mail = null;
    public static $init = null;

    // 初始化
    public function __construct($variable = array())
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            foreach ($variable as $key => $value) {
                $mail->$key = $value;
            }
            static::$init = true;
        } catch (Exception $e) {
            $arr = array();
            $arr[] = $mail->ErrorInfo;
            $arr[] = $e;
            static::$init = $arr;
        }
        static::$mail = $mail;
    }

    // 发送邮件
    public static function send($from = array(), $address = array(), $subject = null, $body = null, $alt = null)
    {
        $mail = static::$mail;
        try {
            // Recipients
            foreach ($from as $key => $value) {
                $mail->setFrom($key, $value);
            }
            foreach ($address as $key => $value) {
                if (is_numeric($key)) {
                    $mail->addAddress($value);
                } else {
                    $mail->addAddress($key, $value);
                }
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            if (null !== $alt) {
                $mail->AltBody = $alt;
            }
            $mail->send();
            return true;
        } catch (Exception $e) {
            $arr = array();
            $arr[] = $mail->ErrorInfo;
            $arr[] = $e;
            return $arr;
        }
        return false;
    }
}
