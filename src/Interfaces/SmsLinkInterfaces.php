<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:45
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;


interface SmsLinkInterfaces
{
    /**
     * Function addScript
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/4/18 14:45
     *
     * @return mixed
     */
    public function addScript();

    /**
     * Function getLink
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/4/18 14:45
     *
     * @param string $phone_number
     * @param string $body
     *
     * @return mixed
     */
    public function getLink($phone_number = '', $body = '');
}
