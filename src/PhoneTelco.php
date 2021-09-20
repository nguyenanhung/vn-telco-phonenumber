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
use nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository;

/**
 * Class Phone_telco
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class PhoneTelco extends BaseCore implements PhoneTelcoInterface
{
    /**
     * PhoneTelco constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->logger->setLoggerSubPath(__CLASS__);
    }

    /**
     * PhoneTelco destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark->mark('code_end');
            $this->logger->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->logger->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

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
    public function carrierData($carrier = '', $output = '')
    {
        $inputParams = array('carrier' => $carrier, 'field_output' => $output);
        $output      = strtolower($output);
        $this->logger->debug(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $vnCarrierData = DataRepository::getData('vn_carrier_data');
            $this->logger->debug(__FUNCTION__, 'VN Carrier All Data: ', $vnCarrierData);
            if (array_key_exists($carrier, $vnCarrierData)) {
                $isCarrier = $vnCarrierData[$carrier];
                $this->logger->debug(__FUNCTION__, 'Is Carrier Data: ' . $isCarrier);
                if (array_key_exists($output, $isCarrier)) {
                    $result = $isCarrier[$output];
                    $this->logger->debug(__FUNCTION__, 'Final Result get Field : ' . $output . $result);

                    return $result;
                }
                if ($output = 'full') {
                    $this->logger->debug(__FUNCTION__, 'Final Result get Field : ' . $output . $isCarrier);

                    return $isCarrier;
                }
            }
        } catch (Exception $e) {
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());

            return $carrier;
        }

        return $carrier;
    }
}
