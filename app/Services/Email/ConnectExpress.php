<?php


namespace App\Services\Email;


class ConnectExpress
{
    
public static function send($email, $message){
$to = $email;
$subject = "OTP";
$txt = $message;
$headers = "Meghalive";

mail($to,$subject,$txt,$headers); 
          return true;
        
    }
}
