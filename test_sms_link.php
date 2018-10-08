<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; // Current Package test, remove if init other package
require_once __DIR__ . DIRECTORY_SEPARATOR . 'classmap.php'; // Current Package test, remove if init other package
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/8/18
 * Time: 16:29
 */

use nguyenanhung\VnTelcoPhoneNumber\SmsLink;

// Test Vars
$my_number = '01632953760';
$my_body   = 'Touch me now!';
// Create
$sms = new SmsLink();

d($sms->getVersion());
d($sms->addScript());
d($sms->getLink($my_number, $my_body));
