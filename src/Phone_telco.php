<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
require_once 'Repository/DataRepository.php';
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\VnTelcoPhoneNumber\Repository;
class Phone_telco
{
    /**
     * Phone_telco constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get Data VN Carrier
     * @param string $carrier
     * @param string $field_output
     * @return null
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        $vn_telco_carrier_data = Repository\DataRepository::getData('vn_telco_carrier_data');
        if (array_key_exists($carrier, $vn_telco_carrier_data)) {
            $is_carrier = $vn_telco_carrier_data[$carrier];
            if (array_key_exists($field_output, $is_carrier)) {
                return $is_carrier[$field_output];
            }
        }
        return null;
    }
}
