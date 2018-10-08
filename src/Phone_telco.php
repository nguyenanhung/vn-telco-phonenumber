<?php

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneTelcoInterface.php';
}
if (!class_exists('nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';
}

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class Phone_telco implements ProjectInterface, PhoneTelcoInterface
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
            $vn_carrier_data = Repository\DataRepository::getData('vn_telco_carrier_data');
            if (array_key_exists($carrier, $vn_carrier_data)) {
                $is_carrier = $vn_carrier_data[$carrier];
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
