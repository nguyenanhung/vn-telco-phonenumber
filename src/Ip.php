<?php
namespace nguyenanhung\VnTelcoPhoneNumber;
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 9/12/18
 * Time: 10:54
 */
class Ip
{
    const IP_KEY = array(
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_IPADDRESS',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_IP',
        'REMOTE_ADDR'
    );

    /**
     * Ip constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get IP by HA Proxy
     * @return bool|string
     */
    public function getIpByHaProxy()
    {
        $ip_keys = array(
            'HTTP_X_FORWARDED_FOR'
        );
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Get IP Address
     * @param bool $convertToInteger
     * @return bool|int|string
     */
    public function getIpAddress($convertToInteger = false)
    {
        foreach (self::IP_KEY as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->ipValidate($ip)) {
                        if ($convertToInteger === true) {
                            return ip2long($ip);
                        }
                        return $ip;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Validate IP
     * @param $ip
     * @return bool
     */
    public function ipValidate($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    /**
     * Get API Infomation
     *
     * @param string $ip
     * @return string
     */
    public function getIpInfomation($ip = '')
    {
        if (empty($ip)) {
            $ip = $this->getIpAddress();
        }
        $curl = new Curl\Curl();
        $curl->get('http://ip-api.com/json/' . $ip);
        $response = $curl->error ? "cURL Error: " . $curl->error_message : $curl->response;
        return $response;
    }

}
