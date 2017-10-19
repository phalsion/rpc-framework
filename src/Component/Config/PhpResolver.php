<?php

namespace Phalsion\RpcFramework\Component\FileLoader;


use Phalsion\RpcFramework\Component\Config\ConfigFileResolver;

/**
 * Class PhpResolver
 *
 * @author  liqi created_at 2017/10/19上午10:27
 * @package \Phalsion\RpcFramework\Component\FileLoader
 */
class PhpResolver implements ConfigFileResolver
{

    public function resolve( $path )
    {
        return [];
    }
}
