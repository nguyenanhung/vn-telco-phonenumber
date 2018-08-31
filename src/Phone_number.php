<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
require_once 'Phone_telco.php';
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 14:09
 */
use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumberToCarrierMapper;
class Phone_number
{
    const VERSION = '1.0.3';
    const DEFAULT_COUNTRY = 'VN';
    const DEFAULT_LANGUAGE = 'vi';
    const DEFAULT_REGION = 'VN';
    protected $normal_name = false;
    /**
     * Phone_number constructor.
     */
    public function __construct()
    {
    }
    /**
     * Set normal Name
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
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }
    /**
     * Format Phone Number
     * @param string $phone_number
     * @param string $format
     * @return string
     * @throws \libphonenumber\NumberParseException
     */
    public function format($phone_number = '', $format = '')
    {
        $phoneNumberUtil   = PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
        if (strtoupper($format) == self::DEFAULT_REGION)
        {
            return (string) '0' . $phoneNumberObject->getNationalNumber();
        }
        else
        {
            return (string) $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();
        }
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
        $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
        $phoneNumberObject = PhoneNumberUtil::getInstance()->parse(trim($phone_number), self::DEFAULT_REGION);
        $carrier           = $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
        if ($get_field_data !== null)
        {
            $phone_telco = new \nguyenanhung\VnTelcoPhoneNumber\Phone_telco();
            $id          = $phone_telco->carrier_data($carrier, $get_field_data);
            return $id;
        }
        if ($this->normal_name === true)
        {
            $phone_telco = new \nguyenanhung\VnTelcoPhoneNumber\Phone_telco();
            $name        = $phone_telco->carrier_data($carrier, 'name');
            if ($name !== null)
            {
                return $name;
            }
        }
        return (string) $carrier;
    }
}
