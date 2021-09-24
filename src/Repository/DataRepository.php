<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m
 * Date: 9/11/18
 * Time: 10:39
 */

namespace nguyenanhung\VnTelcoPhoneNumber\Repository;

use nguyenanhung\VnTelcoPhoneNumber\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\VersionTrait;

/**
 * Class DataRepository
 *
 * @package   nguyenanhung\VnTelcoPhoneNumber\Repository
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class DataRepository implements ProjectInterface
{
    use VersionTrait;

    const CONFIG_PATH = 'config';
    const CONFIG_EXT  = '.php';

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
    public static function getData(string $configName = '')
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_PATH . DIRECTORY_SEPARATOR . $configName . self::CONFIG_EXT;
        if (is_file($path) && file_exists($path)) {
            return require($path);
        }

        return array();
    }
}
