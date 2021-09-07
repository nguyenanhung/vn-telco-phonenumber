<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:45
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Interface SmsLinkInterface
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface SmsLinkInterface
{
    /**
     * Function addScript
     * Call with add Content Js Sms
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:39
     *
     * @return string|null Content Js Sms Link from file config sms_link
     * @see   /Repository/config/sms_link.php
     */
    public function addScript();

    /**
     * Function getLink
     * Get Link include Sms to Sending, use Content place href='''
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:40
     *
     * @param string $phone_number Phone number to parse
     * @param string $body         Body Sms to Sending
     *
     * @return string Content Send Sms
     */
    public function getLink($phone_number = '', $body = '');
}
