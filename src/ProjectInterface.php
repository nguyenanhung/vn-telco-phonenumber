<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:22
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Interface ProjectInterface
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface ProjectInterface
{
    public const VERSION                  = '3.0.3';
    public const LAST_MODIFIED            = '2021-09-20';
    public const DEFAULT_COUNTRY          = 'VN';
    public const DEFAULT_LANGUAGE         = 'vi';
    public const DEFAULT_REGION           = 'VN';
    public const DEFAULT_REGION_CODE      = '84';
    public const HIDDEN_STRING            = '*';
    public const FORMAT_FOR_HUMAN_VIETNAM = 'VN_HUMAN';
    public const FORMAT_E164              = 'E164';
    public const FORMAT_INTERNATIONAL     = 'INTERNATIONAL'; // International
    public const FORMAT_NATIONAL          = 'NATIONAL'; // National
    public const FORMAT_RFC3966           = 'RFC3966';
    public const HIDDEN_REGION            = 'HIDDEN';
    public const HIDDEN_REGION_HEAD       = 'HIDDEN_HEAD';
    public const HIDDEN_REGION_MIDDLE     = 'HIDDEN_MIDDLE';
    public const HIDDEN_REGION_END        = 'HIDDEN_END';
    public const HIDDEN_PLACE_HEAD        = 'HIDDEN_HEAD'; // Ẩn số đầu
    public const HIDDEN_PLACE_MIDDLE      = 'HIDDEN_MIDDLE'; // Ẩn số giữa
    public const HIDDEN_PLACE_END         = 'HIDDEN_END'; // Ẩn số cuối
    public const CONVERT_NEW_TO_OLD       = 'old';
    public const CONVERT_OLD_TO_NEW       = 'new';
    public const MATCH_NUMBER_OLD         = '/^(841[2689])[0-9]{8}$/';
    public const MATCH_NUMBER_NEW         = '/^(84[3785])[0-9]{8}$/';
    public const MAX_LENGTH_NUMBER_OLD    = 12;
    public const MAX_LENGTH_NUMBER_NEW    = 11;
    public const VINAPHONE                = 'Vinaphone'; // ID nhà mạng Vinaphone
    public const VIETTEL                  = 'Viettel Mobile'; // ID nhà mạng Viettel
    public const MOBIFONE                 = 'MobiFone'; // ID nhà mạng MobiFone
    public const VIETNAMOBILE             = 'Vietnamobile'; // ID nhà mạng Vietnamobile
    public const USE_BENCHMARK            = false;

    /**
     * Get current version of Package
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 08:42
     *
     * @return mixed|string Current version of Package, example 1.0.0
     */
    public function getVersion();
}
