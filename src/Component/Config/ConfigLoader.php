<?php

namespace Phalsion\RpcFramework\Component\Config;


use Phalcon\Di;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;

/**
 * Class FileLoader
 *
 * @author  liqi created_at 2017/10/19上午10:02
 * @package \Phalsion\RpcFramework\Component\FileLoader
 */
class ConfigLoader implements ConfigLoaderInterface
{


    public function __construct( $path )
    {
        $this->load($path);
    }

    public function load( $path )
    {
        if ( !file_exists($path) ) {
            throw new RuntimeException(sprintf('配置文件%s没有被找到,请检查配置文件路径!', $path));
        }
        $yml_resolve = new YmlResolver();
        $yml_resolve->setRootPath(dirname($path) . '/');

        $file_extension = pathinfo($path, PATHINFO_EXTENSION);

        if ( $file_extension != 'yml' ) {
            throw new  RuntimeException('配置文件格式不正确！');
        }

        $data = $yml_resolve->resolve($path);

        if ( $data ) {
            $this->register($data);

            return;
        }

    }


    public function register( $data )
    {
        if ( Di::getDefault()->has('config') ) {
            $config = Di::getDefault()->getShared('config');
        } else {
            $config = new Config();
            Di::getDefault()->setShared('config', $config);
        }

        $config->merge(new Config($data));
    }

}
