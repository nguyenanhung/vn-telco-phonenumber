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
    const IP_KEY = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_IPADDRESS', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_CLIENT_IP', 'HTTP_IP', 'REMOTE_ADDR');

    protected $haProxyStatus = false;

    /**
     * Ip constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get IP Address
     * @param bool $convertToInteger
     * @return bool|int|string
     */
    public function getIpAddress($convertToInteger = false)
    {
        if ($this->haProxyStatus === true) {
            return $this->getIpByHaProxy($convertToInteger);
        }
        return $this->getRawIpAddress($convertToInteger);
    }

    /**
     * Set Server use HA Proxy
     *
     * @param bool $haProxyStatus
     * @return $this
     */
    public function setHaProxy($haProxyStatus = false)
    {
        $this->haProxyStatus = $haProxyStatus;
        return $this;
    }

    /**
     * Get IP by HA Proxy
     *
     * @param bool $convertToInteger
     * @return bool|int|string
     */
    public function getIpByHaProxy($convertToInteger = false)
    {
        $ip_keys = array(
            'HTTP_X_FORWARDED_FOR'
        );
        foreach ($ip_keys as $key) {
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
     * Get Raw IP Address
     * @param bool $convertToInteger
     * @return bool|int|string
     */
    public function getRawIpAddress($convertToInteger = false)
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
