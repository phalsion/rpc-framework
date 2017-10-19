<?php

namespace Phalsion\RpcFramework\Component\Config;


use Phalcon\Di;

/**
 * Class Config
 *
 * @author  liqi created_at 2017/10/18下午5:02
 * @package \Phalsion\RpcFramework\Component\Config
 */
class Config extends \Phalcon\Config
{
    public static function env( $path )
    {
        return Di::getDefault()->get('env')->path($path);
    }

    public static function conf( $path )
    {
        return Di::getDefault()->get('config')->path($path);
    }
}
