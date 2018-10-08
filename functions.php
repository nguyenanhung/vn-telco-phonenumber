<?php
/**
 * Project vn-telco-detect.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/19/18
 * Time: 13:54
 */
if (!function_exists('dump')) {
    /**
     * Function dump
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 15:49
     *
     * @param string $str
     */
    function dump($str = '')
    {
        echo "<pre>";
        var_dump($str);
        echo "</pre>";
    }
}
if (!function_exists('testLogPath')) {
    /**
     * Function testLogPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 15:50
     *
     * @return string
     */
    function testLogPath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
    }
}
