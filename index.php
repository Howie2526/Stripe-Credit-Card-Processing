<?php

header('Strict-Transport-Security:max-age=63072000;includeSubDomains;preload');
header('X-Frame-Options:SAMEORIGIN');
header('Referrer-Policy:same-origin');
header('X-XSS-Protection:1;mode=block;');
ini_set('session.cookie_httponly','1');
ini_set('session.cookie_secure','1');
ini_set('session.cookie_samesite','Strict');
session_start();

$ReqSer=$_SERVER['SERVER_NAME'];
$ReqURL=$_SERVER['REQUEST_URI'];
$ReqURL=$ReqSer.$ReqURL;
$LocURL='localhost/cdunion/credit-card-donation/';
$CanURL='cdunion.ca/credit-card-donation/';
if($ReqURL===$LocURL){
	$BaseURL='http://localhost/cdunion/';
	$Root="{$_SERVER['DOCUMENT_ROOT']}/cdunion/";
}elseif(($ReqURL===$CanURL)&&($_SERVER['HTTPS']='on')){
	$BaseURL='https://cdunion.ca/';
	$Root="{$_SERVER['DOCUMENT_ROOT']}/";
}else{
	header("Location:https://$CanURL");
	exit();
}
ob_start();
include('body.php');
$body=ob_get_contents();
ob_end_clean();
$remove=array('/\t/','/\v/');
$replace='';
$body=preg_replace($remove,$replace,$body);
echo($body);
exit();
?>
