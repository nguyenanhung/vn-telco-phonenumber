<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
require_once 'Phone_telco_detect.php';
require_once 'Repository/DataRepository.php';
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 9/12/18
 * Time: 11:27
 */
use nguyenanhung\VnTelcoPhoneNumber\Repository;
class Msisdn
{
    /**
     * Msisdn constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get MSISDN
     *
     * @return bool|null|string
     */
    public function getMsisdn()
    {
        $phoneTelcoDetect = new \nguyenanhung\VnTelcoPhoneNumber\Phone_telco_detect();
        if ($phoneTelcoDetect->isMobifone()) {
            return $this->getRawMsisdn();
        } elseif ($phoneTelcoDetect->isVinaphone()) {
            return $this->getRawMsisdn();
        } else {
            return null;
        }
    }

    /**
     * Get Raw Msisdn
     *
     * @return bool|string
     */
    public function getRawMsisdn()
    {
        $vnm_telco_msisdn_header = Repository\DataRepository::getData('vnm_telco_msisdn_header');
        foreach ($vnm_telco_msisdn_header as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $msisdn) {
                    return trim($msisdn);
                }
            }
        }
        return false;
    }
}
