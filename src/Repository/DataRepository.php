<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 9/11/18
 * Time: 10:39
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Repository;

if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;

/**
 * Class DataRepository
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber\Repository
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class DataRepository implements ProjectInterface
{
    const CONFIG_PATH = 'config';
    const CONFIG_EXT  = '.php';

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/21/18 01:26
     *
     * @return string Current Project Version
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function getData
     * Get Data Content from Config file
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:34
     *
     * @param string $configName Config file name, example: vn_config
     *
     * @return array|mixed Content from file config
     */
    public static function getData($configName = '')
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_PATH . DIRECTORY_SEPARATOR . $configName . self::CONFIG_EXT;
        if (is_file($path) && file_exists($path)) {
            return require($path);
        }

        return [];
    }
}
