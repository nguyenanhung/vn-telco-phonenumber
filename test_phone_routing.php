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

$routing        = new \nguyenanhung\VnTelcoPhoneNumber\PhoneRouting();
$phone          = new \nguyenanhung\VnTelcoPhoneNumber\Phone_number();
$routing_number = '0084002914692692';
$full_number    = '0084914692692';
d($routing->getVersion());
d($routing->checkRoutingNumber(001));
d($routing->isMnp($routing_number));
d($routing->isMnp($full_number));

d($phone->format($routing_number));
d($phone->format($full_number));

d($phone->format($routing_number, 'NATIONAL'));
d($phone->format($full_number, 'NATIONAL'));

$format = $phone->format($routing_number, 'NATIONAL');
$catSo  = mb_substr($format, 0, -9);

d($catSo);