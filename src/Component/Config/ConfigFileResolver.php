<?php

namespace Phalsion\RpcFramework\Component\Config;

/**
 * Interface ConfigFileResolver
 *
 * @author  liqi created_at 2017/10/19上午11:34
 * @package Phalsion\RpcFramework\Component\Config
 */
interface ConfigFileResolver
{
    public function resolve( $path );
}
