<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:30
 */

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterfaces')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterfaces.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\SmsLinkInterfaces')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'SmsLinkInterfaces.php';
}

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterfaces;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\SmsLinkInterfaces;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

class SmsLink implements ProjectInterfaces, SmsLinkInterfaces
{
    /**
     * SmsLink constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/4/18 14:30
     *
     * @return mixed|string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function addScript
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/4/18 14:34
     *
     * @return mixed
     */
    public function addScript()
    {
        $smsLink = Repository\DataRepository::getData('sms_link');

        return $smsLink['script'];
    }

    /**
     * Function getLink
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/4/18 14:45
     *
     * @param string $phone_number
     * @param string $body
     *
     * @return string
     */
    public function getLink($phone_number = '', $body = '')
    {
        if (!empty($body)) {
            $body = "?body=" . $body;
        }
        $sms = 'sms:' . trim($phone_number . $body);

        return $sms;
    }
}
