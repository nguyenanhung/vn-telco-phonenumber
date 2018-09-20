<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:40
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;


interface PhoneNumberInterfaces
{
    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:28
     *
     * @return string
     */
    public function getVersion();

    /**
     * Function setNormalName
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:28
     *
     * @param string $value
     *
     * @return bool
     */
    public function setNormalName($value = '');

    /**
     * Function is_valid
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return bool|null
     */
    public function is_valid($phone_number = '', $region = '');

    /**
     * Function is_possible_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return bool|null
     */
    public function is_possible_number($phone_number = '', $region = '');

    /**
     * Function get_time_zones_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:50
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return mixed
     */
    public function get_time_zones_for_number($phone_number = '', $region = '');

    /**
     * Function get_carrier_name_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:57
     *
     * @param string $phone_number
     * @param string $region
     * @param string $mode
     *
     * @return mixed
     */
    public function get_carrier_name_for_number($phone_number = '', $region = '', $mode = '');

    /**
     * Function get_geocode_description_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:02
     *
     * @param string $phone_number
     * @param string $region
     * @param string $mode
     *
     * @return mixed
     */
    public function get_geocode_description_for_number($phone_number = '', $region = '', $mode = '');

    /**
     * Function get_region_code_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:09
     *
     * @param string $phone_number
     *
     * @return mixed
     */
    public function get_region_code_for_number($phone_number = '');

    /**
     * Function get_country_code_for_region
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:16
     *
     * @param string $region
     *
     * @return mixed
     */
    public function get_country_code_for_region($region = '');

    /**
     * Function get_region_codes_for_country_code
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:18
     *
     * @param string $region_codes
     *
     * @return mixed
     */
    public function get_region_codes_for_country_code($region_codes = '');

    /**
     * Function get_number_type
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:46
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return mixed
     */
    public function get_number_type($phone_number = '', $region = '');

    /**
     * Function check_phone_number_can_be_internationally_dialled
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:12
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return mixed
     */
    public function check_phone_number_can_be_internationally_dialled($phone_number = '', $region = '');

    /**
     * Function find_phone_number_in_string
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:05
     *
     * @param string $text
     * @param string $region
     *
     * @return mixed
     */
    public function find_phone_number_in_string($text = '', $region = '');

    /**
     * Function format
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:30
     *
     * @param string $phone_number
     * @param string $format
     *
     * @return null|string
     */
    public function format($phone_number = '', $format = '');

    /**
     * Function format_hidden
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:30
     *
     * @param string $phone_number
     *
     * @return null|string
     */
    public function format_hidden($phone_number = '');

    /**
     * Function detect_carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:31
     *
     * @param string $phone_number
     * @param string $get_field_data
     *
     * @return null|string
     */
    public function detect_carrier($phone_number = '', $get_field_data = '');

    /**
     * Function vn_convert_phone_number - Convert Phone Number old to new or new to old
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:32
     *
     * @param string $phone_number This is Phone number
     * @param string $phone_mode   This mode as old or new
     * @param string $phone_format This format vn or other
     *
     * @return null|string
     */
    public function vn_convert_phone_number($phone_number = '', $phone_mode = '', $phone_format = '');

    /**
     * Function vn_phone_number_old_and_new - Phone Number Old and New
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:33
     *
     * @param string $phone_number
     * @param string $phone_format
     *
     * @return array|null
     */
    public function vn_phone_number_old_and_new($phone_number = '', $phone_format = '');
}
