<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:36
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Interface PhoneTelcoInterface
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface PhoneTelcoInterface
{
    /**
     * Function Get Data VN Carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:18
     *
     * @param string $carrier Full Name of Carrier: Viettel, Vinaphone, MobiFone, Vietnamobile
     * @param string $output  Field Output: name, id, short_name
     *
     * @return mixed|null Field if exists, full data if field_output = full,  null if not or error
     */
    public function carrier_data($carrier = '', $output = '');

    /**
     * Function carrierData - alias of function carrier_data
     *
     * @param string $carrier
     * @param string $output
     *
     * @return mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/15/2020 20:18
     */
    public function carrierData($carrier = '', $output = '');
}
