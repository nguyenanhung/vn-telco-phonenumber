<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */
class Phone_telco
{
    protected $vn_carrier_data = array('Vinaphone' => array('id' => 1, 'name' => 'Vinaphone', 'short_name' => 'vina'), 'Viettel Mobile' => array('id' => 2, 'name' => 'Viettel', 'short_name' => 'viettel'), 'Viettel' => array('id' => 2, 'name' => 'Viettel', 'short_name' => 'viettel'), 'MobiFone' => array('id' => 3, 'name' => 'Mobifone', 'short_name' => 'mobi'), 'Vietnamobile' => array('id' => 4, 'name' => 'Vietnamobile', 'short_name' => 'vnm'), 'G-Mobile' => array('id' => 5, 'name' => 'G-Mobile', 'short_name' => 'gmobile'), 'Indochina Telecom' => array('id' => 6, 'name' => 'Indochina Telecom', 'short_name' => 'indochina'), 'VSAT' => array('id' => 7, 'name' => 'VSAT', 'short_name' => 'vsat'));
    /**
     * Get Data VN Carrier
     * @param string $carrier
     * @param string $field_output
     * @return null
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        if (array_key_exists($carrier, $this->vn_carrier_data))
        {
            $is_carrier = $this->vn_carrier_data[$carrier];
            if (array_key_exists($field_output, $is_carrier))
            {
                return $is_carrier[$field_output];
            }
        }
        return null;
    }
}
