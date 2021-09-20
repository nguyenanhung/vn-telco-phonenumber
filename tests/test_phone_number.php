<?php
require_once __DIR__ . '/../vendor/autoload.php';

use nguyenanhung\VnTelcoPhoneNumber\Phone_number;

// Test Vars
$my_number = '01632953760';
$my_region = 'vn';
$my_text   = 'So dien thoai cua toi la: ' . $my_number . ' - Ahihi';
d("Phone number: " . $my_number);
// Create
$phone = new Phone_number();
$phone->setDebugStatus(true);
$phone->setLoggerPath(__DIR__ . '/../tmp');
$phone->__construct();
d($phone->getVersion());

// Let's Go Test

d($phone->is_valid($my_number, $my_region));
d($phone->is_possible_number($my_number, $my_region));
d($phone->get_time_zones_for_number($my_number, $my_region));

d($phone->get_carrier_name_for_number($my_number, $my_region, 'safe'));
d($phone->get_carrier_name_for_number($my_number, $my_region, 'valid'));
d($phone->get_carrier_name_for_number($my_number, $my_region, 'any'));

d($phone->get_geocode_description_for_number($my_number, $my_region, 'safe'));
d($phone->get_geocode_description_for_number($my_number, $my_region, 'valid'));
d($phone->get_geocode_description_for_number($my_number, $my_region, 'any'));

d($phone->get_region_code_for_number($my_number, 'VN'));

d($phone->get_country_code_for_region($my_region));
d($phone->get_country_code_for_region($my_region));

d($phone->get_region_codes_for_country_code($my_region));
d($phone->get_number_type($my_number, $my_region));
d($phone->check_phone_number_can_be_internationally_dialled($my_number, $my_region));
d($phone->find_phone_number_in_string($my_text, $my_region));

d($phone->get_national_number($my_number));

d($phone->format($my_number));
d($phone->format($my_number, 'VN'));
d($phone->format($my_number, 'VN_HUMAN'));
d($phone->format($my_number, 'E164'));
d($phone->format($my_number, 'INTERNATIONAL'));
d($phone->format($my_number, 'NATIONAL'));
d($phone->format($my_number, 'RFC3966'));
d($phone->format($my_number, 'HIDDEN'));
d($phone->format($my_number, 'HIDDEN_HEAD'));
d($phone->format($my_number, 'HIDDEN_MIDDLE'));
d($phone->format($my_number, 'HIDDEN_END'));
d($phone->format_hidden($my_number, 'HIDDEN'));
d($phone->format_hidden($my_number, 'HIDDEN_HEAD'));
d($phone->format_hidden($my_number, 'HIDDEN_MIDDLE'));
d($phone->format_hidden($my_number, 'HIDDEN_END'));
d($phone->detect_carrier($my_number));
d($phone->detect_carrier($my_number, 'id'));
d($phone->detect_carrier($my_number, 'name'));
d($phone->detect_carrier($my_number, 'short_name'));
d($phone->vn_convert_phone_number($my_number, 'new'));
d($phone->vn_convert_phone_number($my_number));
d($phone->vn_convert_phone_number($my_number, 'new', 'VN'));
d($phone->vn_convert_phone_number($my_number, 'new', 'VN_HUMAN'));
d($phone->vn_convert_phone_number($my_number, 'new', 'E164'));
d($phone->vn_convert_phone_number($my_number, 'new', 'INTERNATIONAL'));
d($phone->vn_convert_phone_number($my_number, 'new', 'NATIONAL'));
d($phone->vn_convert_phone_number($my_number, 'new', 'RFC3966'));
d($phone->vn_convert_phone_number($my_number, 'new', 'HIDDEN'));
d($phone->vn_convert_phone_number($my_number, 'new', 'HIDDEN_HEAD'));
d($phone->vn_convert_phone_number($my_number, 'new', 'HIDDEN_MIDDLE'));
d($phone->vn_convert_phone_number($my_number, 'new', 'HIDDEN_END'));
d($phone->vn_convert_phone_number($my_number, 'old', 'VN'));
d($phone->vn_convert_phone_number($my_number, 'old', 'VN_HUMAN'));
d($phone->vn_convert_phone_number($my_number, 'old', 'E164'));
d($phone->vn_convert_phone_number($my_number, 'old', 'INTERNATIONAL'));
d($phone->vn_convert_phone_number($my_number, 'old', 'NATIONAL'));
d($phone->vn_convert_phone_number($my_number, 'old', 'RFC3966'));
d($phone->vn_convert_phone_number($my_number, 'old', 'HIDDEN'));
d($phone->vn_convert_phone_number($my_number, 'old', 'HIDDEN_HEAD'));
d($phone->vn_convert_phone_number($my_number, 'old', 'HIDDEN_MIDDLE'));
d($phone->vn_convert_phone_number($my_number, 'old', 'HIDDEN_END'));

d($phone->vn_phone_number_old_and_new($my_number, 'old'));
d($phone->vn_phone_number_old_and_new($my_number, 'new'));
