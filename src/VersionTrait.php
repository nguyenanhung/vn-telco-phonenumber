<?php
/**
 * Project vn-telco-phonenumber
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/15/2020
 * Time: 17:21
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Trait VersionTrait
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait VersionTrait
{
    /**
     * Get current version of Package
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/22/18 08:42
     *
     * @return string Current version of Package
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }
}
