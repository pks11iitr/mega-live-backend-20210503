<?php


namespace App\Services\Email;


class ConnectExpress
{
    
public static function send($email, $message){
$to = $email;
$subject = "OTP";
$txt = $message;
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers); 
          return true;
        
    }
}
