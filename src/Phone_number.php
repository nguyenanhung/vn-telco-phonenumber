<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:40
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumberToCarrierMapper;
use \libphonenumber\PhoneNumberToTimeZonesMapper;
use \libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneNumberInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

/**
 * Class Phone_number
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class Phone_number implements ProjectInterface, PhoneNumberInterface
{
    /**
     * @var object \nguyenanhung\MyDebug\Benchmark
     */
    private $benchmark;
    /**
     * @var object \nguyenanhung\MyDebug\Debug Class Debug Object
     */
    private $debug;
    /**
     * @var bool DEBUG Status
     */
    private $debugStatus = FALSE;
    /**
     * @var null|string Set Debug Level: DEBUG, INFO, ERROR ... etc
     */
    private $debugLevel = NULL;
    /**
     * @var string Logger Path
     */
    private $loggerPath = NULL;
    /**
     * @var null Logger Sub Path
     */
    private $loggerSubPath = NULL;
    /**
     * @var string Filename to write Log
     */
    private $loggerFilename = NULL;
    /**
     * @var bool Set if Call Name Carrier Mixed
     */
    protected $normal_name = FALSE;

    /**
     * Phone_number constructor.
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->debug = new Debug();
        if ($this->debugStatus === TRUE) {
            $this->debug->setDebugStatus($this->debugStatus);
            $this->debug->setGlobalLoggerLevel($this->debugLevel);
            $this->debug->setLoggerPath($this->loggerPath);
            $this->debug->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->loggerFilename = 'Log-' . date('Y-m-d') . '.log';
            }
            $this->debug->setLoggerFilename($this->loggerFilename);
        }
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - Class Phone Number - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * Phone_number destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
        $this->debug->debug(__FUNCTION__, '/-------------------------> End Logger - Class Phone Number - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * Get current version of Package
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 08:42
     *
     * @return mixed|string Current version of Package
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setDebugStatus
     * Set Var to DEBUG and save Log
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:47
     *
     * @param bool $debugStatus TRUE if Enable Debug, other if Not
     *
     * @return mixed|void
     */
    public function setDebugStatus($debugStatus = FALSE)
    {
        $this->debugStatus = $debugStatus;
    }

    /**
     * Function setDebugLevel
     * Set String Debug Level
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:47
     *
     * @param bool|string $debugLevel Level to Set Debug: DEBUG, INFO, ERROR, etc...
     *
     * @return mixed|void
     */
    public function setDebugLevel($debugLevel = NULL)
    {
        $this->debugLevel = $debugLevel;
    }

    /**
     * Function setLoggerPath
     * Main Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 13:51
     *
     * @param bool $loggerPath Set Logger Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void
     */
    public function setLoggerPath($loggerPath = FALSE)
    {
        $this->loggerPath = $loggerPath;
    }

    /**
     * Function setLoggerSubPath
     * Sub Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerSubPath Set Logger Sub Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void
     */
    public function setLoggerSubPath($loggerSubPath = FALSE)
    {
        $this->loggerSubPath = $loggerSubPath;
    }

    /**
     * Function setLoggerFilename
     * Logger filename to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerFilename Set Logger Filename to Save
     *
     * @example Log-2018-10-09.log
     *
     * @return mixed|void
     */
    public function setLoggerFilename($loggerFilename = FALSE)
    {
        $this->loggerFilename = $loggerFilename;
    }

    /**
     * Function setNormalName
     * Hàm gọi tới để lấy tên thường của nhà mạng Viêt (Viettel thay cho Viettl Mobile)
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:28
     *
     * @param bool $value Set TRUE if call name from carrier Data Field
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
     * Function Check Phone Number Is Valid?
     *
     * Check số điện thoại nhập vào có phải 1 số điện thoại đúng hay không
     *
     * Returns a boolean whether the supplied PhoneNumber object is valid or not.
     *
     * Important: This doesn't actually validate whether the number is in use.
     * is only able to validate number patterns, and isn't able to check with telecommunication providers.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number Phone Number Check Valid
     * @param string $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return bool|null True if success, False if not, Null if Error
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
     * Function Check Phone Number Is Possible?
     *
     * Returns a boolean whether the supplied phone number is possible or not.
     * This function accepts either a PhoneNumber object, or a phone number string and a region code (as with parse()).
     *
     * Hàm check số chuỗi nhập vào có phải 1 số điện thoại hay không
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:29
     *
     * @param string $phone_number Phone Number Check Possible
     * @param string $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return bool|null True if success, False if not, Null if Error
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
     * Returns an array of timezones for which the PhoneNumber object supplied belongs in.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:50
     *
     * @param string $phone_number Phone Number to get Timezone
     * @param string $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return array|null Array if Success, Null if Not
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
     * Returns the name of the carrier for the supplied PhoneNumber object within the $language supplied.
     *
     * Returns the same as getNameForNumber() without checking whether it is a valid number for carrier mapping.
     *
     * Returns the same as getNameForNumber(), but only if the number is safe for carrier mapping.
     * A number is only validate for carrier mapping if it's a Mobile or Fixed line,
     * and the country does not support Mobile Number Portability.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:57
     *
     * @param string $phone_number Phone Number to get Carrier Name
     * @param string $region       Region, example VN
     * @param string $mode         Mode String: safe, valid, other...
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return mixed|null|string String if Success, Null if Not
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
     * Returns a text description for the supplied PhoneNumber object, in the $locale language supplied.
     * The description returned might consist of the name of the country, or the name of the geographical area the
     * phone number is from. If $userRegion is supplied, it will also be taken into consideration. If the phone number
     * is from the same region, only a lower-level description will be returned.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 16:11
     *
     * @param string $phone_number Phone Number to get Geo Code Description
     * @param string $region       Region, example VN
     * @param string $mode         Valid String (if $mode=valid -> Returns the same as getDescriptionForNumber(),
     *                             but assumes that you have already checked whether the number is suitable for geo
     *                             location.)
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return mixed|null|string String if Success, Null if Not
     */
    public function get_geocode_description_for_number($phone_number = '', $region = NULL, $mode = '')
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
     * Returns the region code for the PhoneNumber object you pass.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 16:11
     *
     * @param string $phone_number Phone Number to get Region Code
     * @param string $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return mixed|null|string String if Success, Null if Not
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
     * Returns the country calling code for a specific $region.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:16
     *
     * @param null $region example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return int|mixed|null Int if Success, Null if Not
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
     * Returns a list of region codes that match the $region_codes.
     * For a non-geographical country calling codes, the region code 001 is returned.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:18
     *
     * @param null $region_codes example 84
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return array|mixed|null Array if success, null if not
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
     * Returns a PhoneNumberType constant for the PhoneNumber object you pass.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:46
     *
     * @param string $phone_number Phone Number to Get Type
     * @param null   $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return int|mixed|null Int if Success, Null if Not
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
     * Returns a boolean whether the supplied PhoneNumber object can be dialled internationally.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 02:12
     *
     * @param string $phone_number Phone Number to Check
     * @param null   $region       Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return bool|null Bool if Success, Null if Error
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
     * Returns an instance of PhoneNumberMatcher, which can be iterated over (returning PhoneNumberMatch objects).
     * It searches the input $text for phone numbers, using the $defaultRegion.
     * There are also optional parameters to set the phone number $leniency (look in Leniency for possible values),
     * and the $maxTries to search for the phone number.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:51
     *
     * @param string $text   Text String to Find
     * @param null   $region Region, example VN
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see   https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return array|mixed|null Array if Success, Null if not or Error (Set DEBUG to Details)
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
     * Function Format
     * Format Phone Number with Format Style
     * Hàm cho phép Format số điện thoai theo format stype truyền vào
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @time     : 9/21/18 01:30
     *
     * @param string $phone_number Input Phone Number
     * @param string $format       List command:
     *                             VN, VN_HUMAN,
     *                             E164,INTERNATIONAL, NATIONAL, RFC3966,
     *                             HIDDEN, HIDDEN_HEAD, HIDDEN_MIDDLE, HIDDEN_END
     *
     * @example  phone_number = 0163 295 3760, format = Null or Invalid of List command => Output: 841632953760
     * @example  phone_number = 0163 295 3760, format = VN => Output: 01632953760
     * @example  phone_number = 0163 295 3760, format = VN_HUMAN => Output: 0163 295 3760
     * @example  phone_number = 0163 295 3760, format = NATIONAL => Output: 0163 295 3760
     * @example  phone_number = 0163 295 3760, format = INTERNATIONAL => Output: +84 163 295 3760
     * @example  phone_number = 0163 295 3760, format = E164 => Output: +841632953760
     * @example  phone_number = 0163 295 3760, format = RFC3966 => Output: tel:+84-163-295-3760
     * @example  phone_number = 0163 295 3760, format = HIDDEN => Output: 0163 *** 3760
     * @example  phone_number = 0163 295 3760, format = HIDDEN_HEAD => Output: **** 295 3760
     * @example  phone_number = 0163 295 3760, format = HIDDEN_MIDDLE => Output: 0163 *** 3760
     * @example  phone_number = 0163 295 3760, format = HIDDEN_END => Output: 0163 295 ****
     *
     * @see      https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     * @see      https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
     *
     * @return null|string String if Success, Null if Error, Raw phone input if Exception
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
     * Format Hidden Phone number
     * Hàm cho phép format và ẩn đi 1 cụm số theo vị trí,
     * mỗi 1 số điện thoại sẽ chia ra 3 cụm, HEAD, MIDDLE và END
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 14:41
     *
     * @param string $phone_number Input Phone Number
     * @param string $place_hidden Place Hidden: HEAD, MIDDLE or END
     *
     * @example place_hidden = HEAD => **** 123 456
     * @example place_hidden = MIDDLE => 0163 *** 456
     * @example place_hidden = END => 0163 123 ***
     *
     * @see     https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     *
     * @return mixed|null|string String if Success, Null if Error, Raw phone input if Exception
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
     * Detect Carrier from Phone Number
     * Nhận diện nhà mạng từ số điện thoại nhập vào
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:37
     *
     * @param string $phone_number   This is Phone Number to be Detect
     * @param null   $get_field_data Get File Data, keyword: name, short_name, id
     *
     * @return mixed|null|string String if Success, Null if Errro
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
                $phone_telco->setDebugStatus($this->debugStatus);
                $phone_telco->setLoggerPath($this->loggerPath);
                $phone_telco->__construct();
                $result = $phone_telco->carrier_data($carrier, $get_field_data);
                $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

                return (string) $result;
            }
            if ($this->normal_name === TRUE) {
                $phone_telco = new Phone_telco();
                $phone_telco->setDebugStatus($this->debugStatus);
                $phone_telco->setLoggerPath($this->loggerPath);
                $phone_telco->__construct();
                $result = $phone_telco->carrier_data($carrier, 'name');
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
     * Function vn_convert_phone_number
     * Convert Phone Number old to new or new to old
     * Chuyển đổi Số điện thoại từ định dạng mới sang cũ hoặc ngược lại
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:32
     *
     * @param string $phone_number This is Phone number
     * @param string $phone_mode   This mode as old or new
     * @param null   $phone_format This format vn or other, list keyword: VN, VN_HUMAN, E164, INTERNATIONAL, NATIONAL,
     *                             RFC3966, HIDDEN, HIDDEN_HEAD, HIDDEN_MIDDLE, HIDDEN_END
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
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
     * Function vn_phone_number_old_and_new
     * Get Data Phone Number Old and New Convert
     * Lấy về Data Phone Number dạng cũ và mới, dữ liệu trả về dạng Array
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:33
     *
     * @param string $phone_number Phone Number Input
     * @param null   $phone_format Method to Format VN, VN_HUMAN, E164, INTERNATIONAL, NATIONAL, RFC3966, HIDDEN,
     *                             HIDDEN_HEAD, HIDDEN_MIDDLE, HIDDEN_END
     *
     * @see   https://github.com/nguyenanhung/vn-telco-phonenumber/blob/master/test_phone_number.php
     *
     * @return array|null Array if Success, Null if Error
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
