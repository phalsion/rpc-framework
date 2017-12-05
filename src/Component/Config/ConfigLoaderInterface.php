<?php

namespace Phalsion\RpcFramework\Component\Config;

/**
 * Interface ConfigLoaderInterface
 *
 * @author  liqi created_at 2017/10/19上午11:17
 * @package Phalsion\RpcFramework\Component\Config
 */
interface ConfigLoaderInterface
{
    public function register( $data );

    public function load( $dir_path );


}
