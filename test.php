<?php
require 'vendor/autoload.php'; // Current Package test, remove if init other package
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 14:28
 */
function dump($str = '')
{
    echo "<pre>";
    var_dump($str);
    echo "</pre>";
}

require 'src/Phone_number.php';

$phone_number = new \nguyenanhung\VnTelcoPhoneNumber\Phone_number();
$phone        = '0862953761';
dump("Phone number: " . $phone);

// Format Number
$format    = $phone_number->format($phone);
$format_vn = $phone_number->format($phone, 'vn');
dump("Format number: " . $format);
dump("Format number VN: " . $format_vn);

// Hidden Number
$hidden_number = $phone_number->format_hidden($phone);
dump("Format Hidden number: " . $hidden_number);

// Detect Carrier
$detect_carrier = $phone_number->detect_carrier($phone);
dump("Detect Carrier: " . $detect_carrier);

// Convert Fone
$convert    = $phone_number->vn_convert_phone_number($phone, 'new');
$convert_vn = $phone_number->vn_convert_phone_number($phone, 'new', 'vn');

dump("Convert Phone: " . $convert);
dump("Convert PhoneVN: " . $convert_vn);
