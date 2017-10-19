<?php


use \Phalsion\RpcFramework\Component\Config\Config;

/**
 * env.php
 *
 * @author liqi created_at 2017/10/18下午5:01
 */
if ( !function_exists('env') ) {
    function env( $path )
    {
        return Config::env($path);
    }
}

if ( !function_exists('conf') ) {
    function conf( $path )
    {
        return Config::conf($path);
    }
}
