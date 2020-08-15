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
use nguyenanhung\MyDebug\Debug;

/**
 * Class BaseCore
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class BaseCore implements ProjectInterface, LoggerInterface
{
    use VersionTrait, LoggerTrait;

    /** @var object \nguyenanhung\MyDebug\Benchmark */
    protected $benchmark;
    /** @var object \nguyenanhung\MyDebug\Debug Class Debug Object */
    protected $logger;
    /** @var bool DEBUG Status */
    protected $debugStatus = FALSE;
    /** @var null|string Set Debug Level: DEBUG, INFO, ERROR ... etc */
    protected $debugLevel = NULL;
    /** @var string Logger Path */
    protected $loggerPath = NULL;
    /** @var null Logger Sub Path */
    protected $loggerSubPath = NULL;
    /** @var string Filename to write Log */
    protected $loggerFilename = NULL;

    /**
     * BaseCore constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->logger = new Debug();
        if ($this->debugStatus === TRUE) {
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
