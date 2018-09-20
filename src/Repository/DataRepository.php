<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 9/11/18
 * Time: 10:39
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Repository;

class DataRepository
{
    const VERSION     = '1.0.0';
    const CONFIG_PATH = 'config';
    const CONFIG_EXT  = '.php';

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:26
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Get Data
     *
     * @param $configName
     *
     * @return array|mixed
     */
    public static function getData($configName)
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_PATH . DIRECTORY_SEPARATOR . $configName . self::CONFIG_EXT;
        if (is_file($path) && file_exists($path)) {
            return require($path);
        }

        return [];
    }
}
