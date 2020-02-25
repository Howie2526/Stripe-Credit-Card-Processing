<?php

header('Strict-Transport-Security:max-age=63072000;includeSubDomains;preload');
header('X-Frame-Options:SAMEORIGIN');
header('Referrer-Policy:same-origin');
header('X-XSS-Protection:1;mode=block;');
ini_set('session.cookie_httponly','1');
ini_set('session.cookie_secure','1');
ini_set('session.cookie_samesite','Strict');
session_start();

header("Content-type:text/javascript");
$CreditCardInput=file_get_contents('credit-card-input.js');
$remove=array('/\t/','/\v/');
$replace='';
$CreditCardInput=preg_replace($remove,$replace,$CreditCardInput);
echo($CreditCardInput);
exit();
?>
