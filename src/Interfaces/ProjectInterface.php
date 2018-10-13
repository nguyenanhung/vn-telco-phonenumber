<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:22
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;

/**
 * Interface ProjectInterface
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber\Interfaces
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface ProjectInterface
{
    const VERSION                  = '1.1.5.5';
    const LAST_MODIFIED            = '2018-10-13';
    const DEFAULT_COUNTRY          = 'VN';
    const DEFAULT_LANGUAGE         = 'vi';
    const DEFAULT_REGION           = 'VN';
    const DEFAULT_REGION_CODE      = '84';
    const HIDDEN_STRING            = '*';
    const FORMAT_FOR_HUMAN_VIETNAM = 'VN_HUMAN';
    const FORMAT_E164              = 'E164';
    const FORMAT_INTERNATIONAL     = 'INTERNATIONAL'; // International
    const FORMAT_NATIONAL          = 'NATIONAL'; // National
    const FORMAT_RFC3966           = 'RFC3966';
    const HIDDEN_REGION            = 'HIDDEN';
    const HIDDEN_REGION_HEAD       = 'HIDDEN_HEAD';
    const HIDDEN_REGION_MIDDLE     = 'HIDDEN_MIDDLE';
    const HIDDEN_REGION_END        = 'HIDDEN_END';
    const HIDDEN_PLACE_HEAD        = 'HIDDEN_HEAD'; // Ẩn số đầu
    const HIDDEN_PLACE_MIDDLE      = 'HIDDEN_MIDDLE'; // Ẩn số giữa
    const HIDDEN_PLACE_END         = 'HIDDEN_END'; // Ẩn số cuối
    const CONVERT_NEW_TO_OLD       = 'old';
    const CONVERT_OLD_TO_NEW       = 'new';
    const MATCH_NUMBER_OLD         = '/^(841[2689])[0-9]{8}$/';
    const MATCH_NUMBER_NEW         = '/^(84[3785])[0-9]{8}$/';
    const MAX_LENGTH_NUMBER_OLD    = 12;
    const MAX_LENGTH_NUMBER_NEW    = 11;
    const VINAPHONE                = 'Vinaphone'; // ID nhà mạng Vinaphone
    const VIETTEL                  = 'Viettel Mobile'; // ID nhà mạng Viettel
    const MOBIFONE                 = 'MobiFone'; // ID nhà mạng MobiFone
    const VIETNAMOBILE             = 'Vietnamobile'; // ID nhà mạng Vietnamobile

    /**
     * Function getVersion
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 13:38
     *
     * @return mixed|string Current Project Version
     * @example 1.0.0
     */
    public function getVersion();
}
