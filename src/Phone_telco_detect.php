<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
require_once 'Ip.php';
require_once 'Repository/DataRepository.php';
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 5/17/18
 * Time: 15:09
 */

use nguyenanhung\VnTelcoPhoneNumber\Repository;
class Phone_telco_detect
{
    /**
     * Phone_telco constructor.
     */
    public function __construct()
    {
    }

    /**
     * Detect Vinaphone with IP
     *
     * @return bool
     */
    public function isVinaphone()
    {
        $ip_gateway = Repository\DataRepository::getData('vn_telco_ip_gateway');
        $xip        = isset($_SERVER['HTTP_X_IPADDRESS']) ? $_SERVER['HTTP_X_IPADDRESS'] : '';
        if (preg_match($ip_gateway['Vinaphone']['f5_gateway'], $xip)) {
            return true;
        } elseif (preg_match($ip_gateway['Vinaphone']['wap_gateway'], $xip)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Detect Mobifone with IP
     *
     * @return bool
     */
    public function isMobifone()
    {
        $ip_gateway = Repository\DataRepository::getData('vn_telco_ip_gateway');
        $httpip     = isset($_SERVER['HTTP_IP']) ? $_SERVER['HTTP_IP'] : '';
        $ipfw       = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
        if (preg_match($ip_gateway['MobiFone']['f5_gateway'], $httpip)) {
            return true;
        } elseif (preg_match($ip_gateway['MobiFone']['wap_gateway'], $ipfw)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Detect Vietnamobile with IP
     *
     * @param bool $use_ha_proxy
     * @return bool
     */
    public function isVietnamobile($use_ha_proxy = false)
    {
        $ip_gateway = Repository\DataRepository::getData('vn_telco_ip_gateway');
        $ipObject   = new \nguyenanhung\VnTelcoPhoneNumber\Ip();
        $ipObject->setHaProxy($use_ha_proxy);
        $currentIp = $ipObject->getIpAddress();
        if (preg_match($ip_gateway['Vietnamobile']['ip_gateway'], $currentIp)) {
            return true;
        }
        return false;
    }

}
