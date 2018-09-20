<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:36
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;


interface PhoneTelcoInterfaces
{
    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:36
     *
     * @return mixed
     */
    public function getVersion();

    /**
     * Function carrier_data
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:36
     *
     * @param string $carrier
     * @param string $field_output
     *
     * @return mixed
     */
    public function carrier_data($carrier = '', $field_output = '');
}
