<?php
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
$phone_number   = new \nguyenanhung\VnTelcoPhoneNumber\Phone_number();
$phone          = '0163 295 3760';
$format         = $phone_number->format($phone);
$detect_carrier = $phone_number->detect_carrier($phone);
dump($format);
dump($detect_carrier);


