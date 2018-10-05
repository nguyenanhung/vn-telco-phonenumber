<?php

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterfaces')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterfaces.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterfaces')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneTelcoInterfaces.php';
}
if (!class_exists('nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';
}

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterfaces;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterfaces;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class Phone_telco implements ProjectInterfaces, PhoneTelcoInterfaces
{
    /**
     * Phone_telco constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:35
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function carrier_data - Get Data VN Carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:35
     *
     * @param string $carrier
     * @param string $field_output
     *
     * @return null
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        try {
            $vn_telco_carrier_data = Repository\DataRepository::getData('vn_telco_carrier_data');
            if (array_key_exists($carrier, $vn_telco_carrier_data)) {
                $is_carrier = $vn_telco_carrier_data[$carrier];
                if (array_key_exists($field_output, $is_carrier)) {
                    return $is_carrier[$field_output];
                }
            }
        }
        catch (\Exception $e) {
            return NULL;
        }

        return NULL;
    }
}
