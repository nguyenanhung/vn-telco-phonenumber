<?php

namespace nguyenanhung\VnTelcoPhoneNumber;

if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneNumberInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneNumberInterface.php';
}
if (!class_exists('Phone_telco')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Phone_telco.php';
}
if (!class_exists('nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';
}

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 14:09
 */

use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumberToCarrierMapper;
use \libphonenumber\PhoneNumberToTimeZonesMapper;
use \libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneNumberInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class Phone_number implements ProjectInterface, PhoneNumberInterface
{
    const DEFAULT_COUNTRY          = 'VN';
    const DEFAULT_LANGUAGE         = 'vi';
    const DEFAULT_REGION           = 'VN';
    const DEFAULT_REGION_CODE      = '84';
    const HIDDEN_REGION            = 'HIDDEN';
    const HIDDEN_STRING            = '*';
    const FORMAT_FOR_HUMAN_VIETNAM = 'VN_HUMAN';
    const CONVERT_NEW_TO_OLD       = 'old';
    const CONVERT_OLD_TO_NEW       = 'new';
    const MATCH_NUMBER_OLD         = '/^(841[2689])[0-9]{8}$/';
    const MATCH_NUMBER_NEW         = '/^(84[3785])[0-9]{8}$/';
    const MAX_LENGTH_NUMBER_OLD    = 12;
    const MAX_LENGTH_NUMBER_NEW    = 11;
    protected $normal_name = FALSE;

    /**
     * Phone_number constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:28
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setNormalName
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:28
     *
     * @param bool $value
     *
     * @return bool
     */
    public function setNormalName($value = FALSE)
    {
        $this->normal_name = $value;

        return $this->normal_name;
    }

    /**
     * Function is_valid
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number
     * @param null   $region
     *
     * @return bool|null
     */
    public function is_valid($phone_number = '', $region = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);

            return $phoneNumberUtil->isValidNumber($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }

    }

    /**
     * Function is_possible_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number
     * @param null   $region
     *
     * @return bool|null
     */
    public function is_possible_number($phone_number = '', $region = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);

            return $phoneNumberUtil->isPossibleNumber($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_time_zones_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:50
     *
     * @param string $phone_number
     * @param null   $region
     *
     * @return array|null
     */
    public function get_time_zones_for_number($phone_number = '', $region = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $timezoneMapper    = PhoneNumberToTimeZonesMapper::getInstance();

            return $timezoneMapper->getTimeZonesForNumber($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_carrier_name_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:57
     *
     * @param string $phone_number
     * @param null   $region
     * @param null   $mode
     *
     * @return mixed|null|string
     */
    public function get_carrier_name_for_number($phone_number = '', $region = NULL, $mode = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
            if (strtolower($mode) == 'safe') {
                return $carrierMapper->getSafeDisplayName($phoneNumberObject, self::DEFAULT_LANGUAGE);
            } elseif (strtolower($mode) == 'valid') {
                return $carrierMapper->getNameForValidNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            } else {
                return $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            }
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_geocode_description_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:02
     *
     * @param string $phone_number
     * @param null   $region
     * @param null   $mode
     *
     * @return mixed|null|string
     */
    public function get_geocode_description_for_number($phone_number = '', $region = NULL, $mode = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $geoCoder          = PhoneNumberOfflineGeocoder::getInstance();
            if (strtolower($mode) == 'valid') {
                return $geoCoder->getDescriptionForValidNumber($phoneNumberObject, self::DEFAULT_LANGUAGE, $use_region);
            } else {
                return $geoCoder->getDescriptionForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE, $use_region);
            }
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_region_code_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:09
     *
     * @param string $phone_number
     *
     * @return mixed|null|string
     */
    public function get_region_code_for_number($phone_number = '')
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number));

            return $phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_country_code_for_region
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:16
     *
     * @param null $region
     *
     * @return int|mixed|null
     */
    public function get_country_code_for_region($region = NULL)
    {
        try {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $use_region      = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;

            return $phoneNumberUtil->getCountryCodeForRegion($use_region);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_region_codes_for_country_code
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:18
     *
     * @param null $region_codes
     *
     * @return array|mixed|null
     */
    public function get_region_codes_for_country_code($region_codes = NULL)
    {
        try {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $use_region_code = NULL !== $region_codes ? trim($region_codes) : self::DEFAULT_REGION_CODE;

            return $phoneNumberUtil->getRegionCodesForCountryCode($use_region_code);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function get_number_type
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:46
     *
     * @param string $phone_number
     * @param null   $region
     *
     * @return int|mixed|null
     */
    public function get_number_type($phone_number = '', $region = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);

            return $phoneNumberUtil->getNumberType($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function check_phone_number_can_be_internationally_dialled
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:12
     *
     * @param string $phone_number
     * @param null   $region
     *
     * @return bool|null
     */
    public function check_phone_number_can_be_internationally_dialled($phone_number = '', $region = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : NULL;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);

            return $phoneNumberUtil->canBeInternationallyDialled($phoneNumberObject);
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function find_phone_number_in_string
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:05
     *
     * @param string $text
     * @param null   $region
     *
     * @return array|mixed|null
     */
    public function find_phone_number_in_string($text = '', $region = NULL)
    {
        if (empty($text)) {
            return NULL;
        }
        try {
            $phoneNumberUtil    = PhoneNumberUtil::getInstance();
            $use_region         = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberMatcher = $phoneNumberUtil->findNumbers($text, $use_region);
            $result             = [];
            foreach ($phoneNumberMatcher as $phoneNumberMatch) {
                $result['number'][] = $phoneNumberMatch->number();
            }

            return $result;
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

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
    public function format($phone_number = '', $format = '')
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
            if (strtoupper(trim($format)) == self::DEFAULT_REGION) {
                return (string) '0' . $phoneNumberObject->getNationalNumber();
            } elseif (strtoupper(trim($format)) == self::HIDDEN_REGION) {
                return (string) $this->format_hidden($phone_number);
            } elseif (strtoupper(trim($format)) == self::FORMAT_FOR_HUMAN_VIETNAM) {
                return (string) $phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, self::DEFAULT_COUNTRY);
            } else {
                return (string) $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();
            }
        }
        catch (\Exception $e) {
            return $phone_number;
        }
    }

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
    public function format_hidden($phone_number = '')
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil     = PhoneNumberUtil::getInstance();
            $phoneNumberObject   = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
            $phoneNumberVnFormat = $phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, "VN");
            $exPhone             = explode(' ', $phoneNumberVnFormat);
            $result              = count($exPhone) > 1 ? trim($exPhone[0]) . trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[1]))) . trim($exPhone[2]) : $phoneNumberVnFormat;

            return $result;
        }
        catch (\Exception $e) {
            return $phone_number;
        }
    }

    /**
     * Function detect_carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:31
     *
     * @param string $phone_number
     * @param null   $get_field_data
     *
     * @return null|string
     */
    public function detect_carrier($phone_number = '', $get_field_data = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        try {
            $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
            $phoneNumberObject = PhoneNumberUtil::getInstance()->parse(trim($phone_number), self::DEFAULT_REGION);
            $carrier           = $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            if ($get_field_data !== NULL) {
                $phone_telco = new Phone_telco();
                $id          = $phone_telco->carrier_data($carrier, $get_field_data);

                return $id;
            }
            if ($this->normal_name === TRUE) {
                $phone_telco = new Phone_telco();
                $name        = $phone_telco->carrier_data($carrier, 'name');
                if ($name !== NULL) {
                    return $name;
                }
            }

            return (string) $carrier;
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * Function vn_convert_phone_number - Convert Phone Number old to new or new to old
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:32
     *
     * @param string $phone_number This is Phone number
     * @param string $phone_mode   This mode as old or new
     * @param null   $phone_format This format vn or other
     *
     * @return null|string
     */
    public function vn_convert_phone_number($phone_number = '', $phone_mode = '', $phone_format = NULL)
    {
        if (empty($phone_number)) {
            return NULL;
        }
        $mode = strtolower($phone_mode); // old || new
        // Convert Phone Number to CountryCode + NationalNumber
        $phone_number = $this->format(trim($phone_number));
        try {
            // Data Convert Phone Number
            $dataVnConvertPhoneNumber = Repository\DataRepository::getData('vn_convert_phone_number');
            if (is_array($dataVnConvertPhoneNumber) && count($dataVnConvertPhoneNumber) > 0) {
                if ($mode == self::CONVERT_NEW_TO_OLD) {
                    $preg_match_number = self::MATCH_NUMBER_NEW;
                } elseif ($mode == self::CONVERT_OLD_TO_NEW) {
                    $preg_match_number = self::MATCH_NUMBER_OLD;
                } else {
                    $preg_match_number = NULL;
                }
                if ($preg_match_number !== NULL) {
                    if (!preg_match($preg_match_number, $phone_number)) {
                        return $this->format($phone_number, $phone_format);
                    }
                    foreach ($dataVnConvertPhoneNumber as $old_number_prefix => $new_number_prefix) {
                        if ($mode == self::CONVERT_NEW_TO_OLD) {
                            $phone_number_content = self::MAX_LENGTH_NUMBER_NEW - strlen($new_number_prefix); // 84 + number content
                            $phone_number_prefix  = $new_number_prefix;
                            $convert_prefix       = $old_number_prefix;
                        } elseif ($mode == self::CONVERT_OLD_TO_NEW) {
                            $phone_number_content = self::MAX_LENGTH_NUMBER_OLD - strlen($old_number_prefix); // 84 + number content
                            $phone_number_prefix  = $old_number_prefix;
                            $convert_prefix       = $new_number_prefix;
                        } else {
                            $phone_number_content = NULL;
                            $phone_number_prefix  = NULL;
                            $convert_prefix       = NULL;
                        }
                        if (($phone_number_content !== NULL && $phone_number_prefix !== NULL && $convert_prefix !== NULL) && preg_match('/^(' . $phone_number_prefix . ')[0-9]{' . $phone_number_content . '}$/', $phone_number)) {
                            // Cắt lấy các số cuối tính từ vị trí đầu tiên trong dãy $phone_number rồi nối đầu số $convert_prefix
                            $phone_number = $convert_prefix . substr($phone_number, strlen($phone_number_prefix), $phone_number_content);
                            $phone_number = $this->format($phone_number, $phone_format);

                            return $phone_number;
                        }
                    }
                }
            } else {
                return NULL;
            }
        }
        catch (\Exception $e) {
            return NULL;
        }

        return NULL;
    }

    /**
     * Function vn_phone_number_old_and_new - Phone Number Old and New
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:33
     *
     * @param string $phone_number
     * @param null   $phone_format
     *
     * @return array|null
     */
    public function vn_phone_number_old_and_new($phone_number = '', $phone_format = NULL)
    {
        try {
            $old_number = $this->vn_convert_phone_number(trim($phone_number), 'old', $phone_format);
            $new_number = $this->vn_convert_phone_number(trim($phone_number), 'new', $phone_format);
            if (!empty($old_number) && !empty($new_number)) {
                return (array) [
                    $old_number,
                    $new_number
                ];
            }
        }
        catch (\Exception $e) {
            return NULL;
        }

        return NULL;
    }
}
