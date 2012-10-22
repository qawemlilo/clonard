<?php
define('PASSWORD', 'phipson');
define('MERCHID', '79YW25SUQC');
define('USERNAME', 'heather@clonard.co.za');

/*
  Mail function created by Que
*/

function send_mail($name, $email, $to) 
{
$mailtext = "A new order has been made from the Clonard Website by: ";
$mailtext .= "\n---------------------------------------------------";
$mailtext .= "\n Name: \t ".$name;
$mailtext .= "\n Email: \t ".$email;
$mailtext .= "\n---------------------------------------------------";
$mailtext .= "\n\nPlease login to www.clonard.co.za as an administrator to view new order.";

    $headers = '';
	$headers .= "From: Clonard Website\n";
	$headers .= "Reply-to: no-reply@clonard.co.za\n";
	$headers .= "Return-Path: no-reply@clonard.co.za\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "Date: " . date('r', time()) . "\n";
	
	mail($to,"New Order", $mailtext, $headers);
}

function send_decline_mail($name, $email, $to) 
{
$mailtext = "A new order payment has been declined for: ";
$mailtext .= "\n---------------------------------------------------";
$mailtext .= "\n Name: \t ".$name;
$mailtext .= "\n Email: \t ".$email;
$mailtext .= "\n---------------------------------------------------";
$mailtext .= "\n\nPlease login to www.clonard.co.za as an administrator to view order with declined payment.";

    $headers = '';
	$headers .= "From: Clonard Website\n";
	$headers .= "Reply-to: no-reply@clonard.co.za\n";
	$headers .= "Return-Path: no-reply@clonard.co.za\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "Date: " . date('r', time()) . "\n";
	
	mail($to,"New Order", $mailtext, $headers);
}