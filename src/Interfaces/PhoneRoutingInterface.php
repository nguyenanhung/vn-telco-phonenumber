<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/22/18
 * Time: 09:02
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;

/**
 * Interface PhoneRoutingInterface
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber\Interfaces
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface PhoneRoutingInterface
{
    const NUMBER_PREFIX = '00';

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
    public function setDebugStatus($debugStatus = FALSE);

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
    public function setDebugLevel($debugLevel = NULL);

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
    public function setLoggerPath($loggerPath = FALSE);

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
    public function setLoggerSubPath($loggerSubPath = FALSE);

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
    public function setLoggerFilename($loggerFilename = FALSE);

    /**
     * Hàm kiểm tra tính hợp lệ của Routing number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 10:28
     *
     * @param string $routingNumber Routing Number của nhà mạng
     *
     * @return null|array Mảng dữ liệu của nhà mạng nếu tồn tại, null nếu không tồn tại
     */
    public function checkRoutingNumber($routingNumber = '');

    /**
     * Hàm kiểm tra số thuê bao có thuộc tập MNP hay không
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 12:02
     *
     * @param string $called số thuê bao đầu vào
     *
     * @return bool|null TRUE nếu thuộc MNP, FALSE nếu không thuộc MNP, NULL nếu called là rỗng
     */
    public function isMnp($called = '');

    /**
     * Hàm lấy Routing Number từ số điện thoại Input vào
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 20:20
     *
     * @param string $called Số điện thoại cần kiểm tra
     *
     * @return bool|null|string Routing Number trả về nếu hợp lệ, FALSE nếu không hợp lệ, Null nếu không thuộc dải MNP
     */
    public function getRoutingNumberFromCalled($called = '');

    /**
     * Hàm lấy thông tin nhà mạng từ Routing Number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 20:33
     *
     * @param string      $number Số cần check: 0084 + RN + MSISDN
     * @param null|string $field  Tham số telco cần check
     *
     * @return array|mixed|null|string Thông tin nhà mạng trong trường hợp thành công
     *                                 Null nếu Routing number không hợp lệ
     */
    public function detectCarrierFromRoutingNumber($number = '', $field = NULL);
}
