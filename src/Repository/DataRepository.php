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
    /**
     * Get Data
     * @param $configName
     * @return array|mixed
     */
    public static function getData($configName)
    {
        $path = __DIR__ . '/config/' . $configName . '.php';
        if (is_file($path)) {
            return require($path);
        }
        return array();
    }
}
