<?php
/**
 * Project vn-telco-phonenumber
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/15/2020
 * Time: 17:19
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Class Phone_telco - Polyfill for PhoneTelco
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Phone_telco extends PhoneTelco
{
    /**
     * Function carrier_data
     *
     * @param string $carrier
     * @param string $output
     *
     * @return mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/07/2021 44:55
     */
    public function carrier_data(string $carrier = '', string $output = '')
    {
        return $this->carrierData($carrier, $output);
    }
}
