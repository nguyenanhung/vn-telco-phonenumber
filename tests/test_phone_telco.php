<?php
require_once __DIR__ . '/../vendor/autoload.php';

use nguyenanhung\VnTelcoPhoneNumber\Phone_telco;

// Test Vars
$my_number = '01632953760';
$my_region = 'vn';
$my_text   = 'So dien thoai cua toi la: ' . $my_number . ' - Ahihi';
d("Phone number: " . $my_number);
// Create
$tel = new Phone_telco();
$tel->setDebugStatus(true);
$tel->setLoggerPath(__DIR__ . '/../tmp');
$tel->__construct();
d($tel->getVersion());

d($tel->carrier_data('Viettel', 'id'));
d($tel->carrier_data('Viettel', 'name'));
d($tel->carrier_data('Viettel', 'short_name'));
d($tel->carrier_data('Viettel Mobile', 'id'));
d($tel->carrier_data('Viettel Mobile', 'name'));
d($tel->carrier_data('Viettel Mobile', 'short_name'));
d($tel->carrier_data('MobiFone', 'id'));
d($tel->carrier_data('MobiFone', 'name'));
d($tel->carrier_data('MobiFone', 'short_name'));
d($tel->carrier_data('Mobifone', 'id'));
d($tel->carrier_data('Mobifone', 'name'));
d($tel->carrier_data('Mobifone', 'short_name'));
d($tel->carrier_data('Vietnamobile', 'id'));
d($tel->carrier_data('Vietnamobile', 'name'));
d($tel->carrier_data('Vietnamobile', 'short_name'));
d($tel->carrier_data('G-Mobile', 'id'));
d($tel->carrier_data('G-Mobile', 'name'));
d($tel->carrier_data('G-Mobile', 'short_name'));
d($tel->carrier_data('Indochina Telecom', 'id'));
d($tel->carrier_data('Indochina Telecom', 'name'));
d($tel->carrier_data('Indochina Telecom', 'short_name'));
d($tel->carrier_data('VSAT', 'id'));
d($tel->carrier_data('VSAT', 'name'));
d($tel->carrier_data('VSAT', 'short_name'));