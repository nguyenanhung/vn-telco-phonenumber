<?php
/**
 * Project vn-telco-phonenumber
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/15/2020
 * Time: 17:24
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

/**
 * Trait LoggerTrait
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 *
 * @property mixed debugStatus
 * @property mixed debugLevel
 * @property mixed loggerPath
 * @property mixed loggerSubPath
 * @property mixed loggerFilename
 */
trait LoggerTrait
{
    /**
     * Function setDebugStatus - Set Var to DEBUG and save Log
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:47
     *
     * @param bool $debugStatus TRUE if Enable Debug, other if Not
     *
     * @return mixed|void|$this
     */
    public function setDebugStatus($debugStatus = FALSE)
    {
        $this->debugStatus = $debugStatus;

        return $this;
    }

    /**
     * Function setDebugLevel - Set String Debug Level
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:47
     *
     * @param bool|string $debugLevel Level to Set Debug: DEBUG, INFO, ERROR, etc...
     *
     * @return mixed|void|$this
     */
    public function setDebugLevel($debugLevel = NULL)
    {
        $this->debugLevel = $debugLevel;

        return $this;
    }

    /**
     * Function setLoggerPath - Main Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 13:51
     *
     * @param bool $loggerPath Set Logger Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void|$this
     */
    public function setLoggerPath($loggerPath = FALSE)
    {
        $this->loggerPath = $loggerPath;

        return $this;
    }

    /**
     * Function setLoggerSubPath - Sub Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerSubPath Set Logger Sub Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void|$this
     */
    public function setLoggerSubPath($loggerSubPath = FALSE)
    {
        $this->loggerSubPath = $loggerSubPath;

        return $this;
    }

    /**
     * Function setLoggerFilename - Logger filename to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerFilename Set Logger Filename to Save
     *
     * @example Log-2018-10-09.log
     *
     * @return mixed|void|$this
     */
    public function setLoggerFilename($loggerFilename = FALSE)
    {
        $this->loggerFilename = $loggerFilename;

        return $this;
    }
}
