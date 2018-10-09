<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:36
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Interfaces;

/**
 * Interface PhoneTelcoInterface
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber\Interfaces
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface PhoneTelcoInterface
{
    /**
     * Function setDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $debugStatus
     *
     * @return mixed
     */
    public function setDebugStatus($debugStatus = FALSE);

    /**
     * Function setLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerPath
     *
     * @return mixed
     */
    public function setLoggerPath($loggerPath = FALSE);

    /**
     * Function setLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerSubPath
     *
     * @return mixed
     */
    public function setLoggerSubPath($loggerSubPath = FALSE);

    /**
     * Function setLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerFilename
     *
     * @return mixed
     */
    public function setLoggerFilename($loggerFilename = FALSE);

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
