<?php
session_start();
$server = $_SERVER['SERVER_NAME'];
$request = $_SERVER['REQUEST_URI'];
$canonical = '/stripe/';
if ($server === "localhost") {
	$root = $_SERVER['DOCUMENT_ROOT'] . "/cdunion/";
	$base = 'http://localhost/cdunion/';
} elseif (($request !== $canonical) || ($_SERVER['HTTPS'] != 'on')) {
	header ('Location: https://cdunion.ca/stripe/', true, 301);
} else {
	$root = $_SERVER['DOCUMENT_ROOT'];
	$base = 'https://cdunion.ca/';
}
include ($root . '/stripe/body.php');
die();
?>
