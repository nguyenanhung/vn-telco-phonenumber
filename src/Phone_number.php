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
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneNumberInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class Phone_number implements ProjectInterface, PhoneNumberInterface
{
    private   $debug;
    private   $debugStatus    = FALSE;
    private   $loggerPath     = 'logs';
    private   $loggerSubPath  = NULL;
    private   $loggerFilename = 'app.log';
    protected $normal_name    = FALSE;

    /**
     * Phone_number constructor.
     */
    public function __construct()
    {
        $this->debug = new Debug();
        if ($this->debugStatus === TRUE) {
            $this->debug->setDebugStatus($this->debugStatus);
            $this->debug->setLoggerPath($this->loggerPath);
            $this->debug->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->debug->setLoggerFilename($this->loggerFilename);
            } else {
                $this->debug->setLoggerFilename('Log-' . date('Y-m-d') . '.log');
            }
        }
        $this->debug->debug(__FUNCTION__, '/---------------------------> Class Phone Number <---------------------------\\');
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
     * Function setDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:36
     *
     * @param bool $debugStatus
     */
    public function setDebugStatus($debugStatus = FALSE)
    {
        $this->debugStatus = $debugStatus;
    }

    /**
     * Function setLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerPath
     *
     * @return mixed|void
     */
    public function setLoggerPath($loggerPath = FALSE)
    {
        $this->loggerFilename = $loggerPath;
    }

    /**
     * Function setLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerSubPath
     *
     * @return mixed|void
     */
    public function setLoggerSubPath($loggerSubPath = FALSE)
    {
        $this->loggerSubPath = $loggerSubPath;
    }

    /**
     * Function setLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerFilename
     *
     * @return mixed|void
     */
    public function setLoggerFilename($loggerFilename = FALSE)
    {
        $this->loggerFilename = $loggerFilename;
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
        $this->debug->info(__FUNCTION__, 'setNormalName: ', $this->normal_name);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $result            = $phoneNumberUtil->isValidNumber($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $result            = $phoneNumberUtil->isPossibleNumber($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $timezoneMapper    = PhoneNumberToTimeZonesMapper::getInstance();
            $result            = $timezoneMapper->getTimeZonesForNumber($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region,
            'mode'         => $mode
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
            if (strtolower($mode) == 'safe') {
                $result = $carrierMapper->getSafeDisplayName($phoneNumberObject, self::DEFAULT_LANGUAGE);
            } elseif (strtolower($mode) == 'valid') {
                $result = $carrierMapper->getNameForValidNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            } else {
                $result = $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            }
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region,
            'mode'         => $mode
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $geoCoder          = PhoneNumberOfflineGeocoder::getInstance();
            if (strtolower($mode) == 'valid') {
                $result = $geoCoder->getDescriptionForValidNumber($phoneNumberObject, self::DEFAULT_LANGUAGE, $use_region);
            } else {
                $result = $geoCoder->getDescriptionForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE, $use_region);
            }
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return NULL;
        }
    }

    /**
     * Function get_region_code_for_number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 16:11
     *
     * @param string $phone_number
     * @param string $region
     *
     * @return mixed|null|string
     */
    public function get_region_code_for_number($phone_number = '', $region = '')
    {
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region,
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $result            = $phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ' . $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'region' => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $use_region      = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $result          = $phoneNumberUtil->getCountryCodeForRegion($use_region);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'region_codes' => $region_codes
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $use_region_code = NULL !== $region_codes ? trim($region_codes) : self::DEFAULT_REGION_CODE;
            $result          = $phoneNumberUtil->getRegionCodesForCountryCode($use_region_code);
            $this->debug->debug(__FUNCTION__, 'Use REGION Code: ' . $use_region_code);
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : self::DEFAULT_REGION;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $result            = $phoneNumberUtil->getNumberType($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ' . $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'region'       => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $use_region        = NULL !== $region ? strtoupper($region) : NULL;
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), $use_region);
            $result            = $phoneNumberUtil->canBeInternationallyDialled($phoneNumberObject);
            $this->debug->debug(__FUNCTION__, 'Use REGION: ' . $use_region);
            $this->debug->info(__FUNCTION__, 'Final Result: ' . $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'text'   => $text,
            'region' => $region
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($text)) {
            $this->debug->warning(__FUNCTION__, 'Text input is Empty!');

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
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
     * @param string $format List command:
     *                       VN, VN_HUMAN, E164,
     *                       INTERNATIONAL, NATIONAL, RFC3966,
     *                       HIDDEN, HIDDEN_HEAD, HIDDEN_MIDDLE, HIDDEN_END
     *
     * @return null|string
     */
    public function format($phone_number = '', $format = '')
    {
        $inputParams = [
            'phone_number' => $phone_number,
            'format'       => $format
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        $format       = strtoupper(trim($format));
        $hidden_list  = [
            self::HIDDEN_REGION,
            self::HIDDEN_REGION_HEAD,
            self::HIDDEN_REGION_MIDDLE,
            self::HIDDEN_REGION_END
        ];
        $this->debug->warning(__FUNCTION__, 'Hidden List Allowed: ', $hidden_list);
        try {
            $phoneNumberUtil   = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
            if ($format == self::DEFAULT_REGION) {
                $result = (string) '0' . $phoneNumberObject->getNationalNumber();
            } elseif (in_array($format, $hidden_list)) {
                $result = (string) $this->format_hidden($phone_number, $format);
            } elseif ($format == self::FORMAT_FOR_HUMAN_VIETNAM) {
                $result = (string) $phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, self::DEFAULT_COUNTRY);
            } elseif ($format == self::FORMAT_E164) {
                $result = (string) $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::E164);
            } elseif ($format == self::FORMAT_INTERNATIONAL) {
                $result = (string) $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
            } elseif ($format == self::FORMAT_NATIONAL) {
                $result = (string) $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::NATIONAL);
            } elseif ($format == self::FORMAT_RFC3966) {
                $result = (string) $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::RFC3966);
            } else {
                $result = (string) $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();
            }
            $this->debug->debug(__FUNCTION__, 'Format Result: ' . $result . ' with Format: ' . $format);
            $this->debug->info(__FUNCTION__, 'Final Result: ' . $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return $phone_number;
        }
    }

    /**
     * Function format_hidden
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 13:54
     *
     * @param string $phone_number Input Phone Number
     * @param string $place_hidden Place Hidden: HEAD, MIDDLE or END
     *                             $place_hidden = HEAD => **** 123 456
     *                             $place_hidden = MIDDLE => 0163 *** 456
     *                             $place_hidden = END => 0163 123 ***
     *
     * @return null|string
     */
    public function format_hidden($phone_number = '', $place_hidden = '')
    {
        $inputParams = [
            'phone_number' => $phone_number,
            'place_hidden' => $place_hidden
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $phone_number = trim($phone_number);
        $place_hidden = strtoupper($place_hidden);
        try {
            $phoneNumberUtil     = PhoneNumberUtil::getInstance();
            $phoneNumberObject   = $phoneNumberUtil->parse(trim($phone_number), self::DEFAULT_REGION);
            $phoneNumberVnFormat = $phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, "VN");
            /**
             * Phone Number: 0163 123 456
             * $place_hidden = HEAD => **** 123 456
             * $place_hidden = MIDDLE => 0163 *** 456
             * $place_hidden = END => 0163 123 ***
             */
            $exPhone = explode(' ', $phoneNumberVnFormat);
            if (count($exPhone) > 1) {
                if ($place_hidden == self::HIDDEN_PLACE_HEAD) {
                    $result = trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[0]))) . trim($exPhone[1]) . trim($exPhone[2]);
                    $this->debug->debug(__FUNCTION__, 'Place Hidden is: ' . self::HIDDEN_PLACE_HEAD);
                    $this->debug->debug(__FUNCTION__, 'Result Hidden: ', $result);
                } elseif ($place_hidden == self::HIDDEN_PLACE_MIDDLE) {
                    $result = trim($exPhone[0]) . trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[1]))) . trim($exPhone[2]);
                    $this->debug->debug(__FUNCTION__, 'Place Hidden is: ' . self::HIDDEN_PLACE_MIDDLE);
                    $this->debug->debug(__FUNCTION__, 'Result Hidden: ', $result);
                } elseif ($place_hidden == self::HIDDEN_PLACE_END) {
                    $result = trim($exPhone[0]) . trim($exPhone[4]) . trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[2])));
                    $this->debug->debug(__FUNCTION__, 'Place Hidden is: ' . self::HIDDEN_PLACE_END);
                    $this->debug->debug(__FUNCTION__, 'Result Hidden: ', $result);
                } else {
                    $result = trim($exPhone[0]) . trim(str_repeat(self::HIDDEN_STRING, strlen($exPhone[1]))) . trim($exPhone[2]);
                    $this->debug->debug(__FUNCTION__, 'Place Hidden is: ' . $place_hidden);
                    $this->debug->debug(__FUNCTION__, 'Result Hidden: ', $result);
                }
            } else {
                $result = $phoneNumberVnFormat;
                $this->debug->debug(__FUNCTION__, 'Unavailable Hidden for ' . $place_hidden . ' with Phone Number: ' . $phone_number);
                $this->debug->debug(__FUNCTION__, 'Result Hidden: ', $result);
            }
            $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

            return $result;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number'   => $phone_number,
            'get_field_data' => $get_field_data
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        try {
            $carrierMapper     = PhoneNumberToCarrierMapper::getInstance();
            $phoneNumberObject = PhoneNumberUtil::getInstance()->parse(trim($phone_number), self::DEFAULT_REGION);
            $carrier           = $carrierMapper->getNameForNumber($phoneNumberObject, self::DEFAULT_LANGUAGE);
            $this->debug->debug(__FUNCTION__, 'Carrier Detect from ' . $phone_number . ' is ', $carrier);
            if ($get_field_data !== NULL) {
                $phone_telco = new Phone_telco();
                $result      = $phone_telco->carrier_data($carrier, $get_field_data);
                $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

                return $result;
            }
            if ($this->normal_name === TRUE) {
                $phone_telco = new Phone_telco();
                $result      = $phone_telco->carrier_data($carrier, 'name');
                if ($result !== NULL) {
                    return $result;
                }
                $this->debug->info(__FUNCTION__, 'Final Result: ', $result);
            }
            $this->debug->info(__FUNCTION__, 'Final Result: ', $carrier);

            return (string) $carrier;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'phone_mode'   => $phone_mode,
            'phone_format' => $phone_format,
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        if (empty($phone_number)) {
            $this->debug->warning(__FUNCTION__, 'Phone Number input is Empty!');

            return NULL;
        }
        $mode = strtolower($phone_mode); // old || new
        // Convert Phone Number to CountryCode + NationalNumber
        $phone_number = $this->format(trim($phone_number));
        try {
            // Data Convert Phone Number
            $dataVnConvertPhoneNumber = Repository\DataRepository::getData('vn_convert_phone_number');
            $this->debug->debug(__FUNCTION__, 'Data Convert Phone Number: ', $dataVnConvertPhoneNumber);
            if (is_array($dataVnConvertPhoneNumber) && count($dataVnConvertPhoneNumber) > 0) {
                if ($mode == self::CONVERT_NEW_TO_OLD) {
                    $preg_match_number = self::MATCH_NUMBER_NEW;
                    $this->debug->debug(__FUNCTION__, 'Mode is New to Old with Preg Match: ', $preg_match_number);
                } elseif ($mode == self::CONVERT_OLD_TO_NEW) {
                    $preg_match_number = self::MATCH_NUMBER_OLD;
                    $this->debug->debug(__FUNCTION__, 'Mode is Old to New with Preg Match: ', $preg_match_number);
                } else {
                    $preg_match_number = NULL;
                }
                if ($preg_match_number !== NULL) {
                    if (!preg_match($preg_match_number, $phone_number)) {
                        $result = $this->format($phone_number, $phone_format);
                        $this->debug->warning(__FUNCTION__, 'Phone Number: ' . $phone_number . ' Invalid with Rule: ' . $preg_match_number . ' -> Output Result: ' . $result);

                        return $result;
                    }
                    foreach ($dataVnConvertPhoneNumber as $old_number_prefix => $new_number_prefix) {
                        if ($mode == self::CONVERT_NEW_TO_OLD) {
                            $phone_number_content = self::MAX_LENGTH_NUMBER_NEW - strlen($new_number_prefix); // 84 + number content
                            $phone_number_prefix  = $new_number_prefix;
                            $convert_prefix       = $old_number_prefix;
                            $this->debug->debug(__FUNCTION__, 'Data Convert New to Old: ', [
                                'phone_number_content' => $phone_number_content,
                                'phone_number_prefix'  => $phone_number_prefix,
                                'convert_prefix'       => $convert_prefix
                            ]);
                        } elseif ($mode == self::CONVERT_OLD_TO_NEW) {
                            $phone_number_content = self::MAX_LENGTH_NUMBER_OLD - strlen($old_number_prefix); // 84 + number content
                            $phone_number_prefix  = $old_number_prefix;
                            $convert_prefix       = $new_number_prefix;
                            $this->debug->debug(__FUNCTION__, 'Data Convert Old to New: ', [
                                'phone_number_content' => $phone_number_content,
                                'phone_number_prefix'  => $phone_number_prefix,
                                'convert_prefix'       => $convert_prefix
                            ]);
                        } else {
                            $phone_number_content = NULL;
                            $phone_number_prefix  = NULL;
                            $convert_prefix       = NULL;
                            $this->debug->debug(__FUNCTION__, 'Phone Number Invalid Rule Convert: ', [
                                'phone_number_content' => $phone_number_content,
                                'phone_number_prefix'  => $phone_number_prefix,
                                'convert_prefix'       => $convert_prefix
                            ]);
                        }
                        // Rule to check
                        $ruleCheckConvert = '/^(' . $phone_number_prefix . ')[0-9]{' . $phone_number_content . '}$/';
                        $this->debug->debug(__FUNCTION__, 'Rule preg_match Check to Convert Number: ' . $phone_number . ' is ', $ruleCheckConvert);
                        if (($phone_number_content !== NULL && $phone_number_prefix !== NULL && $convert_prefix !== NULL) && preg_match($ruleCheckConvert, $phone_number)) {
                            // Cắt lấy các số cuối tính từ vị trí đầu tiên trong dãy $phone_number rồi nối đầu số $convert_prefix
                            $phone_number = $convert_prefix . substr($phone_number, strlen($phone_number_prefix), $phone_number_content);
                            $this->debug->debug(__FUNCTION__, 'Rule Check OK -> Phone Number Convert: ', $phone_number);
                            $phone_number = $this->format($phone_number, $phone_format);
                            $this->debug->info(__FUNCTION__, 'Rule Check OK -> Phone Number Final Result Format: ', $phone_number);

                            return $phone_number;
                        }
                    }
                }
            } else {
                $message = 'Invalid or Unavailable Data Convert - Data: ';
                $this->debug->error(__FUNCTION__, $message, $dataVnConvertPhoneNumber);

                return NULL;
            }
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

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
        $inputParams = [
            'phone_number' => $phone_number,
            'phone_format' => $phone_format
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $old_number = $this->vn_convert_phone_number(trim($phone_number), 'old', $phone_format);
            $new_number = $this->vn_convert_phone_number(trim($phone_number), 'new', $phone_format);
            $this->debug->debug(__FUNCTION__, 'Old Number: ', $old_number);
            $this->debug->debug(__FUNCTION__, 'New Number: ', $new_number);
            if (!empty($old_number) && !empty($new_number)) {
                $result = [
                    $old_number,
                    $new_number
                ];
                $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

                return (array) $result;
            }
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return NULL;
        }

        return NULL;
    }
}
