<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; // Current Package test, remove if init other package
require_once __DIR__ . DIRECTORY_SEPARATOR . 'classmap.php'; // Current Package test, remove if init other package
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 14:28
 */

use nguyenanhung\VnTelcoPhoneNumber\Phone_number;

// Test Vars
$my_number = '01632953760';
d("Phone number: " . $my_number);
// Create
$phone = new Phone_number();
$phone->setDebugStatus(true);
$phone->setLoggerPath(testLogPath());
d($phone->getVersion());
d(testLogPath());

// Format Number
d($phone->is_valid($my_number));

