<?php

namespace nguyenanhung\VnTelcoPhoneNumber;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneTelcoInterfaces.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterfaces;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class Phone_telco implements PhoneTelcoInterfaces
{
    const VERSION = '1.1.0';

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
