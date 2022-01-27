<?php


namespace App\Services\Email;


class ConnectExpress
{
    
public static function send($email, $message){
$to = $email;
$subject = "OTP";
$txt = $message;
<<<<<<< HEAD
$headers = "Meghalive";
=======
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";
>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1

mail($to,$subject,$txt,$headers); 
          return true;
        
    }
}
