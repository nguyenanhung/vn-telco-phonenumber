<?php
/**
 * Project vn-telco-phonenumber
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/15/2020
 * Time: 17:22
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Class Phone_number
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Phone_number extends PhoneNumber
{
    /**
     * Function Check Phone Number Is Valid? - Check số điện thoại nhập vào có phải 1 số điện thoại đúng hay không
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
    public function is_valid($phone_number = '', $region = null)
    {
        return $this->isValid($phone_number, $region);
    }

    /**
     * Function Check Phone Number Is Possible? - Hàm check số chuỗi nhập vào có phải 1 số điện thoại hay không
     *
     * Returns a boolean whether the supplied phone number is possible or not.
     * This function accepts either a PhoneNumber object, or a phone number string and a region code (as with parse()).
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
    public function is_possible_number($phone_number = '', $region = null)
    {
        return $this->isPossibleNumber($phone_number, $region);
    }

    /**
     * Function getTimeZonesForNumber - Returns an array of timezones for which the PhoneNumber object supplied belongs in.
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
    public function get_time_zones_for_number($phone_number = '', $region = null)
    {
        return $this->getTimeZonesForNumber($phone_number, $region);
    }

    /**
     * Function getCarrierNameForNumber
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
     * @return null|string String if Success, Null if Not
     */
    public function get_carrier_name_for_number($phone_number = '', $region = null, $mode = null)
    {
        return $this->getCarrierNameForNumber($phone_number, $region, $mode);
    }

    /**
     * Function getGeocodeDescriptionForNumber
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
     * @return null|string String if Success, Null if Not
     */
    public function get_geocode_description_for_number($phone_number = '', $region = null, $mode = null)
    {
        return $this->getGeocodeDescriptionForNumber($phone_number, $region, $mode);
    }

    /**
     * Function getRegionCodeForNumber
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
     * @return null|string String if Success, Null if Not
     */
    public function get_region_code_for_number($phone_number = '', $region = null)
    {
        return $this->getRegionCodeForNumber($phone_number, $region);
    }

    /**
     * Function getCountryCodeForRegion
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
     * @return int|null Int if Success, Null if Not
     */
    public function get_country_code_for_region($region = null)
    {
        return $this->getCountryCodeForRegion($region);
    }

    /**
     * Function getRegionCodesForCountryCode
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
     * @return array|null Array if success, null if not
     */
    public function get_region_codes_for_country_code($region_codes = null)
    {
        return $this->getRegionCodesForCountryCode($region_codes);
    }

    /**
     * Function getNumberType
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
     * @return int|null Int if Success, Null if Not
     */
    public function get_number_type($phone_number = '', $region = null)
    {
        return $this->getNumberType($phone_number, $region);
    }

    /**
     * Function checkPhoneNumberCanBeInternationallyDialled
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
    public function check_phone_number_can_be_internationally_dialled($phone_number = '', $region = null)
    {
        return $this->checkPhoneNumberCanBeInternationallyDialled($phone_number, $region);
    }

    /**
     * Function findPhoneNumberInString
     *
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
     * @return array|null Array if Success, Null if not or Error (Set DEBUG to Details)
     */
    public function find_phone_number_in_string($text = '', $region = null)
    {
        return $this->findPhoneNumberInString($text, $region);
    }

    /**
     * Function getNationalNumber
     *
     * Returns the national number of this phone number.
     *
     * @param string $phone_number
     *
     * @return string|null  The national number, or null if not set.
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 12/25/19 00:52
     */
    public function get_national_number($phone_number = '')
    {
        return $this->getNationalNumber($phone_number);
    }

    /**
     * Function formatHidden - Format Hidden Phone number
     *
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
     * @return null|string String if Success, Null if Error, Raw phone input if Exception
     */
    public function format_hidden($phone_number = '', $place_hidden = '')
    {
        return $this->formatHidden($phone_number, $place_hidden);
    }

    /**
     * Function detectCarrier - Detect Carrier from Phone Number
     *
     * Nhận diện nhà mạng từ số điện thoại nhập vào
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:37
     *
     * @param string $phone_number   This is Phone Number to be Detect
     * @param null   $get_field_data Get File Data, keyword: name, short_name, id
     *
     * @return null|string String if Success, Null if Error
     */
    public function detect_carrier($phone_number = '', $get_field_data = null)
    {
        return $this->detectCarrier($phone_number, $get_field_data);
    }

    /**
     * Function vnConvertPhoneNumber - Convert Phone Number old to new or new to old
     *
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
    public function vn_convert_phone_number($phone_number = '', $phone_mode = '', $phone_format = null)
    {
        return $this->vnConvertPhoneNumber($phone_number, $phone_mode, $phone_format);
    }

    /**
     * Function vnPhoneNumberOldAndNew - Get Data Phone Number Old and New Convert
     *
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
     * @return array|null|string Array if Success, Null if Error
     */
    public function vn_phone_number_old_and_new($phone_number = '', $phone_format = null)
    {
        return $this->vnPhoneNumberOldAndNew($phone_number, $phone_format);
    }
}
