<?php
require_once __DIR__ . '/../vendor/autoload.php';

use nguyenanhung\VnTelcoPhoneNumber\PhoneRouting;
use nguyenanhung\VnTelcoPhoneNumber\Phone_number;

$routing        = new PhoneRouting();
$phone          = new Phone_number();
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