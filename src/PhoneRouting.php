<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/22/18
 * Time: 08:44
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneRoutingInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository;

/**
 * Class PhoneRouting
 *
 * Thiết kế theo chuẩn tài liệu - MNP - Help Documentation
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class PhoneRouting implements ProjectInterface, PhoneRoutingInterface
{
    const IS_MNP_LENGTH = 16;
    /** @var object \nguyenanhung\VnTelcoPhoneNumber\Phone_number */
    private $phoneNumber;
    /** @var object \nguyenanhung\VnTelcoPhoneNumber\Phone_telco */
    private $phoneTelco;
    /** @var object \nguyenanhung\MyDebug\Benchmark */
    private $benchmark;
    /** @var object \nguyenanhung\MyDebug\Debug Class Debug Object */
    private $debug;
    /** @var bool DEBUG Status */
    private $debugStatus = FALSE;
    /** @var null|string Set Debug Level: DEBUG, INFO, ERROR ... etc */
    private $debugLevel = NULL;
    /** @var string Logger Path */
    private $loggerPath = NULL;
    /** @var null Logger Sub Path */
    private $loggerSubPath = NULL;
    /** @var string Filename to write Log */
    private $loggerFilename = NULL;

    /**
     * PhoneRouting constructor.
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
        $this->phoneNumber = new Phone_number();
        $this->phoneTelco  = new Phone_telco();
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - Class Phone Number - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * PhoneRouting destructor.
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
     * Hàm kiểm tra tính hợp lệ của Routing number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 10:28
     *
     * @param string $routingNumber Routing Number của nhà mạng
     *
     * @return null|array Mảng dữ liệu của nhà mạng nếu tồn tại, null nếu không tồn tại
     */
    public function checkRoutingNumber($routingNumber = '')
    {
        $routing = (string) strval($routingNumber);
        $routing = self::NUMBER_PREFIX . $routing;
        $data    = DataRepository::getData('vn_routing_number');
        if (isset($data[$routing])) {
            return $data[$routing];
        } else {
            return NULL;
        }
    }

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
    public function isMnp($called = '')
    {
        if (empty($called)) {
            return NULL;
        }
        // Format new: 0084 + RN + MSISDN -> 0084002914692692 -> str_len = 16
        // Format old: 0084 + MSISDN -> 0084914692692 -> str_len = 13
        $length = mb_strlen($called);
        if ($length == self::IS_MNP_LENGTH) {
            $isMnp = TRUE;
        } else {
            $isMnp = FALSE;
        }

        return $isMnp;
    }

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
    public function getRoutingNumberFromCalled($called = '')
    {
        if ($this->isMnp($called) === TRUE) {
            // Số nằm trong dải chuyển
            $format = $this->phoneNumber->format($called, self::FORMAT_NATIONAL);
            // Đặt trong trường hợp tất cả số điện thoại đã chuyển sang dạng 10 số
            $routingNumber = mb_substr($format, 0, -9);
            if ($this->checkRoutingNumber($routingNumber) !== NULL) {
                return $routingNumber;
            } else {
                return FALSE;
            }
        } else {
            return NULL;
        }
    }

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
    public function detectCarrierFromRoutingNumber($number = '', $field = NULL)
    {
        $checkNumberIsMnp = $this->isMnp($number);
        if ($checkNumberIsMnp === TRUE) {
            // Số thuộc dải MNP
            $routingNumber = $this->getRoutingNumberFromCalled($number);
            if (!empty($routingNumber)) {
                // Routing number hợp lệ
                $routingName = $this->checkRoutingNumber($routingNumber);
                if (empty($field)) {
                    $result = $routingName;
                } else {
                    $result = $this->phoneTelco->carrier_data($routingName, $field);
                }
            } else {
                // Routing number không hợp lệ
                $result = NULL;
            }
        } else {
            // Số không thuộc dải MNP
            $number = $this->phoneNumber->format($number);
            $result = $this->phoneNumber->detect_carrier($number, $field);
        }

        return $result;
    }
}
