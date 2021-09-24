<?php
/**
 * Project vn-telco-phonenumber
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/15/2020
 * Time: 17:32
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyDebug\Logger;

/**
 * Class BaseCore
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class BaseCore implements ProjectInterface
{
    use VersionTrait, LoggerTrait;

    /**
     * @var \nguyenanhung\MyDebug\Benchmark $benchmark
     */
    protected $benchmark;

    /**
     * @var \nguyenanhung\MyDebug\Logger $logger
     */
    protected $logger;

    /** @var bool DEBUG Status */
    protected $debugStatus = false;

    /** @var null|string Set Debug Level: DEBUG, INFO, ERROR ... etc */
    protected $debugLevel = 'error';

    /** @var string Logger Path */
    protected $loggerPath = '';

    /** @var null Logger Sub Path */
    protected $loggerSubPath = '';

    /** @var string Filename to write Log */
    protected $loggerFilename = '';

    /**
     * BaseCore constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->logger = new Logger();
        if ($this->debugStatus === true) {
            $this->logger->setDebugStatus($this->debugStatus);
            $this->logger->setGlobalLoggerLevel($this->debugLevel);
            $this->logger->setLoggerPath($this->loggerPath);
            $this->logger->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->loggerFilename = 'Log-' . date('Y-m-d') . '.log';
            }
            $this->logger->setLoggerFilename($this->loggerFilename);
        }
    }
}
