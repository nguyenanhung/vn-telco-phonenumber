<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

use nguyenanhung\VnTelcoPhoneNumber\SmsLink;

// Test Vars
$my_number = '01632953760';
$my_body   = 'Touch me now!';
// Create
$sms = new SmsLink();

d($sms->getVersion());
d($sms->addScript());
d($sms->getLink($my_number, $my_body));
