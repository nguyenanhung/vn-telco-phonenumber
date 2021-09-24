<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/22/18
 * Time: 08:44
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

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
class PhoneRouting extends BaseCore
{
    const IS_MNP_LENGTH = 16;
    const NUMBER_PREFIX = '00';

    /** @var object \nguyenanhung\VnTelcoPhoneNumber\PhoneNumber */
    private $phoneNumber;

    /** @var object \nguyenanhung\VnTelcoPhoneNumber\PhoneTelco */
    private $phoneTelco;

    /**
     * PhoneRouting constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->logger->setLoggerSubPath(__CLASS__);
        $this->phoneNumber = new PhoneNumber();
        $this->phoneTelco  = new PhoneTelco();
    }

    /**
     * PhoneRouting destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark->mark('code_end');
            $this->logger->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->logger->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

    /**
     * Hàm kiểm tra tính hợp lệ của Routing number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 10:28
     *
     * @param string $routingNumber Routing Number của nhà mạng
     *
     * @return null|string|array Mảng dữ liệu của nhà mạng nếu tồn tại, null nếu không tồn tại
     */
    public function checkRoutingNumber(string $routingNumber = '')
    {
        $routing = $routingNumber;
        $routing = self::NUMBER_PREFIX . $routing;
        $data    = DataRepository::getData('vn_routing_number');

        return $data[$routing] ?? null;
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
    public function isMnp(string $called = '')
    {
        if (empty($called)) {
            return null;
        }
        // Format new: 0084 + RN + MSISDN -> 0084002914692692 -> str_len = 16
        // Format old: 0084 + MSISDN -> 0084914692692 -> str_len = 13
        $length = mb_strlen($called);

        return $length === self::IS_MNP_LENGTH;
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
    public function getRoutingNumberFromCalled(string $called = '')
    {
        if ($this->isMnp($called) === true) {
            // Số nằm trong dải chuyển
            $format = $this->phoneNumber->format($called, self::FORMAT_NATIONAL);
            // Đặt trong trường hợp tất cả số điện thoại đã chuyển sang dạng 10 số
            $routingNumber = mb_substr($format, 0, -9);
            if ($this->checkRoutingNumber($routingNumber) !== null) {
                return $routingNumber;
            }

            return false;
        }

        return null;
    }

    /**
     * Hàm lấy thông tin nhà mạng từ Routing Number
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 20:33
     *
     * @param string      $number Số cần check: 0084 + RN + MSISDN
     * @param string|null $field  Tham số telco cần check
     *
     * @return array|mixed|null|string Thông tin nhà mạng trong trường hợp thành công
     *                                 Null nếu Routing number không hợp lệ
     */
    public function detectCarrierFromRoutingNumber(string $number = '', string $field = null)
    {
        $checkNumberIsMnp = $this->isMnp($number);
        if ($checkNumberIsMnp === true) {
            // Số thuộc dải MNP
            $routingNumber = $this->getRoutingNumberFromCalled($number);
            if (!empty($routingNumber)) {
                // Routing number hợp lệ
                $routingName = $this->checkRoutingNumber($routingNumber);
                if (empty($field)) {
                    $result = $routingName;
                } else {
                    $result = $this->phoneTelco->carrierData($routingName, $field);
                }

                return $result;
            }

            // Routing number không hợp lệ
            return null;
        }
        // Số không thuộc dải MNP
        $number_format = $this->phoneNumber->format($number);
        if ($number_format === null) {
            return null;
        }

        return $this->phoneNumber->detectCarrier($number_format, $field);

    }
}
