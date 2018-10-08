<?php

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneTelcoInterface.php';
}
if (!class_exists('nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';
}

/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository;

class Phone_telco implements ProjectInterface, PhoneTelcoInterface
{
    private $debug;
    private $debugStatus    = FALSE;
    private $loggerPath     = 'logs';
    private $loggerSubPath  = NULL;
    private $loggerFilename = 'app.log';

    /**
     * Phone_telco constructor.
     */
    public function __construct()
    {
        $this->debug = new Debug();
        if ($this->debugStatus === TRUE) {
            $this->debug->setDebugStatus($this->debugStatus);
            $this->debug->setLoggerPath($this->loggerPath);
            $this->debug->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->debug->setLoggerFilename($this->loggerFilename);
            } else {
                $this->debug->setLoggerFilename('Log-' . date('Y-m-d') . '.log');
            }
        }
        $this->debug->debug(__FUNCTION__, '/---------------------------> Class Phone Telco <---------------------------\\');
    }

    /**
     * Function setDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:36
     *
     * @param bool $debugStatus
     */
    public function setDebugStatus($debugStatus = FALSE)
    {
        $this->debugStatus = $debugStatus;
    }

    /**
     * Function setLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerPath
     *
     * @return mixed|void
     */
    public function setLoggerPath($loggerPath = FALSE)
    {
        $this->loggerFilename = $loggerPath;
    }

    /**
     * Function setLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerSubPath
     *
     * @return mixed|void
     */
    public function setLoggerSubPath($loggerSubPath = FALSE)
    {
        $this->loggerSubPath = $loggerSubPath;
    }

    /**
     * Function setLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 14:38
     *
     * @param bool $loggerFilename
     *
     * @return mixed|void
     */
    public function setLoggerFilename($loggerFilename = FALSE)
    {
        $this->loggerFilename = $loggerFilename;
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:35
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function carrier_data - Get Data VN Carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:35
     *
     * @param string $carrier
     * @param string $field_output
     *
     * @return null
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        $inputParams = [
            'carrier'      => $carrier,
            'field_output' => $field_output
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $vnCarrierData = DataRepository::getData('vn_carrier_data');
            $this->debug->debug(__FUNCTION__, 'VN Carrier All Data: ', $vnCarrierData);
            if (array_key_exists($carrier, $vnCarrierData)) {
                $isCarrier = $vnCarrierData[$carrier];
                $this->debug->debug(__FUNCTION__, 'Is Carrier Data: ', $isCarrier);
                if (array_key_exists($field_output, $isCarrier)) {
                    $result = $isCarrier[$field_output];
                    $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

                    return $result;
                }
            }
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return NULL;
        }

        return NULL;
    }
}
