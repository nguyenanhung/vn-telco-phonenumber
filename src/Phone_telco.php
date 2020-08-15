<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:40
 */

namespace nguyenanhung\VnTelcoPhoneNumber;

use Exception;
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\LoggerInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository;

/**
 * Class Phone_telco
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class Phone_telco implements ProjectInterface, LoggerInterface, PhoneTelcoInterface
{
    use VersionTrait, LoggerTrait;

    /** @var object \nguyenanhung\MyDebug\Benchmark */
    protected $benchmark;
    /** @var object \nguyenanhung\MyDebug\Debug Class Debug Object */
    protected $debug;
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
     * Phone_telco constructor.
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
        $this->debug = new Debug();
        if ($this->debugStatus === TRUE) {
            $this->debug->setDebugStatus($this->debugStatus);
            $this->debug->setGlobalLoggerLevel($this->debugLevel);
            $this->debug->setLoggerPath($this->loggerPath);
            $this->debug->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->loggerFilename = 'Log-' . date('Y-m-d') . '.log';
            }
            $this->debug->setLoggerFilename($this->loggerFilename);
        }
    }

    /**
     * Phone_telco destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

    /**
     * Function Get Data VN Carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:18
     *
     * @param string $carrier      Full Name of Carrier: Viettel, Vinaphone, MobiFone, Vietnamobile
     * @param string $field_output Field Output: name, id, short_name
     *
     * @return mixed|null Field if exists, full data if field_output = full,  null if not or error
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        $inputParams  = array(
            'carrier'      => $carrier,
            'field_output' => $field_output
        );
        $field_output = strtolower($field_output);
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $vnCarrierData = DataRepository::getData('vn_carrier_data');
            $this->debug->debug(__FUNCTION__, 'VN Carrier All Data: ', $vnCarrierData);
            if (array_key_exists($carrier, $vnCarrierData)) {
                $isCarrier = $vnCarrierData[$carrier];
                $this->debug->debug(__FUNCTION__, 'Is Carrier Data: ', $isCarrier);
                if (array_key_exists($field_output, $isCarrier)) {
                    $result = $isCarrier[$field_output];
                    $this->debug->info(__FUNCTION__, 'Final Result get Field : ' . $field_output, $result);

                    return $result;
                }
                if ($field_output = 'full') {
                    $this->debug->info(__FUNCTION__, 'Final Result get Field : ' . $field_output, $isCarrier);

                    return $isCarrier;
                }
            }
        }
        catch (Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return NULL;
        }

        return NULL;
    }

    /**
     * Function carrierData - alias of function carrier_data
     *
     * @param string $carrier
     * @param string $field_output
     *
     * @return mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/15/2020 20:18
     */
    public function carrierData($carrier = '', $field_output = '')
    {
        return $this->carrier_data($carrier, $field_output);
    }
}
