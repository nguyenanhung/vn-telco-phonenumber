<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
require_once 'Phone_telco.php';
require_once 'Repository/DataRepository.php';
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 14:09
 */
use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumberToCarrierMapper;
use nguyenanhung\VnTelcoPhoneNumber\Repository;
class Phone_number
{
    const VERSION = '1.0.8';
    const DEFAULT_COUNTRY = 'VN';
    const DEFAULT_LANGUAGE = 'vi';
    const DEFAULT_REGION = 'VN';
    const HIDDEN_REGION = 'HIDDEN';
    const HIDDEN_STRING = '*';
    const CONVERT_NEW_TO_OLD = 'old';
    const CONVERT_OLD_TO_NEW = 'new';
    const MATCH_NUMBER_OLD = '/^(841[2689])[0-9]{8}$/';
    const MATCH_NUMBER_NEW = '/^(84[3785])[0-9]{8}$/';
    const MAX_LENGTH_NUMBER_OLD = 12;
    const MAX_LENGTH_NUMBER_NEW = 11;
    protected $normal_name = false;

    /**
     * Phone_number constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set normal Name
     *
     * Viettel no Viettel Mobile :))
     *
     * @param bool $value
     * @return bool
     */
    public function setNormalName($value = false)
    {
        $this->normal_name = $value;
        return $this->normal_name;
    }

    /**
     * Get Version
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Format Phone Number
     *
     * @param string $phone_number
     * @param string $format
     * @return string
     * @throws \libphonenumber\NumberParseException
     */
    public function format($phone_number = '', $format = '')
    {
        if (empty($phone_number)) {
            return null;
        }
        $phone_number      = trim($phone_number);
        $phoneNumberUtil   = PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
        if (strtoupper(trim($format)) == self::DEFAULT_REGION) {
            return (string) '0' . $phoneNumberObject->getNationalNumber();
        } elseif (strtoupper(trim($format)) == self::HIDDEN_REGION) {
            return (string) $this->format_hidden($phone_number);
        } else {
            return (string) $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();
        }
    }

    /**
     * Hidden 3 number in Phone number
     *
     * @param string $phone_number
     * @return null|string
     * @throws \libphonenumber\NumberParseException
     */
    public function format_hidden($phone_number = '')
    {
        if (empty($phone_number)) {
            return null;
        }
        $phone_number        = trim($phone_number);
        $phoneNumberUtil     = PhoneNumberUtil::getInstance();
        $phoneNumberObject   = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
        $phoneNumberVnFormat = $phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, "VN");
        $exPhone             = explode(' ', $phoneNumberVnFormat);
        $result              = count($exPhone) > 1 ? trim($exPhone[0]) . trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[1]))) . trim($exPhone[2]) : $phoneNumberVnFormat;
        return $result;
    }

    /**
     * Detect Carrier
     *
     * @param string $phone_number
     * @param null $get_field_data
     * @return null|string
     * @throws \libphonenumber\NumberParseException
     */
    public function detect_carrier($phone_number = '', $get_field_data = null)
    {
        if (empty($phone_number)) {
            return null;
        }
        $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
        $phoneNumberObject = PhoneNumberUtil::getInstance()->parse(trim($phone_number), self::DEFAULT_REGION);
        $carrier           = $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
        if ($get_field_data !== null) {
            $phone_telco = new \nguyenanhung\VnTelcoPhoneNumber\Phone_telco();
            $id          = $phone_telco->carrier_data($carrier, $get_field_data);
            return $id;
        }
        if ($this->normal_name === true) {
            $phone_telco = new \nguyenanhung\VnTelcoPhoneNumber\Phone_telco();
            $name        = $phone_telco->carrier_data($carrier, 'name');
            if ($name !== null) {
                return $name;
            }
        }
        return (string) $carrier;
    }

    /**
     *
     * Convert Phone Number old to new or new to old
     *
     * @param string $phone_number This is Phone number
     * @param string $phone_mode This mode as old or new
     * @param string $phone_format This format vn or other
     * @return bool|null|string
     * @throws \libphonenumber\NumberParseException
     */
    public function vn_convert_phone_number($phone_number = '', $phone_mode = '', $phone_format = null)
    {
        if (empty($phone_number)) {
            return null;
        }
        $mode                     = strtolower($phone_mode); // old || new
        // Convert Phone Number to CountryCode + NationalNumber
        $phone_number             = $this->format(trim($phone_number));
        // Data Convert Phone Number
        $dataVnConvertPhoneNumber = Repository\DataRepository::getData('vn_convert_phone_number');
        if (is_array($dataVnConvertPhoneNumber) && count($dataVnConvertPhoneNumber) > 0) {
            if ($mode == self::CONVERT_NEW_TO_OLD) {
                $preg_match_number = self::MATCH_NUMBER_NEW;
            } elseif ($mode == self::CONVERT_OLD_TO_NEW) {
                $preg_match_number = self::MATCH_NUMBER_OLD;
            } else {
                $preg_match_number = null;
            }
            if ($preg_match_number !== null) {
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
                        $phone_number_content = null;
                        $phone_number_prefix  = null;
                        $convert_prefix       = null;
                    }
                    if (($phone_number_content !== null && $phone_number_prefix !== null && $convert_prefix !== null) && preg_match('/^(' . $phone_number_prefix . ')[0-9]{' . $phone_number_content . '}$/', $phone_number)) {
                        // Cắt lấy các số cuối tính từ vị trí đầu tiên trong dãy $phone_number rồi nối đầu số $convert_prefix
                        $phone_number = $convert_prefix . substr($phone_number, strlen($phone_number_prefix), $phone_number_content);
                        $phone_number = $this->format($phone_number, $phone_format);
                        return $phone_number;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Phone Number Old and New
     *
     * @param string $phone_number
     * @param string $phone_format
     * @return array|null
     * @throws \libphonenumber\NumberParseException
     */
    public function vn_phone_number_old_and_new($phone_number = '', $phone_format = null)
    {
        $old_number = $this->vn_convert_phone_number(trim($phone_number), 'old', $phone_format);
        $new_number = $this->vn_convert_phone_number(trim($phone_number), 'new', $phone_format);
        if (!empty($old_number) && !empty($new_number)) {
            return (array) array(
                $old_number,
                $new_number
            );
        }
        return null;
    }
}
