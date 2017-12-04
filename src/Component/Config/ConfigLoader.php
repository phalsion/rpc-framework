<?php

namespace Phalsion\RpcFramework\Component\FileLoader;


use Phalsion\RpcFramework\Component\Config\Config;
use Phalsion\RpcFramework\Component\Config\YmlResolver;
use Phalsion\RpcFramework\Component\RpcKernel\KernelInterface;

/**
 * Class FileLoader
 *
 * @author  liqi created_at 2017/10/19上午10:02
 * @package \Phalsion\RpcFramework\Component\FileLoader
 */
class ConfigLoader
{

    protected $kernel;

    public function __construct( KernelInterface $kernel )
    {
        $this->kernel = $kernel;
    }

    public function load( $path )
    {
        $yml_resolve = new YmlResolver();
        if ( !file_exists($path) ) {
            throw new \RuntimeException(sprintf('配置文件%s没有被找到,请检查配置文件路径!', $path));
        }

        $file_extension = pathinfo($path, PATHINFO_EXTENSION);

        if ( $file_extension != 'yml' ) {
            throw new \RuntimeException('配置文件格式不正确！');
        }

        $data = $yml_resolve->resolve($path);

        if ( $data ) {
            $this->register($data);

            return;
        }

    }


    public function register( $data )
    {
        if ( $this->kernel->getDI()->has('config') ) {
            $config = $this->kernel->getDI()->getShared('config');
        } else {
            $config = new Config();
            $this->kernel->getDI()->setShared('config', $config);
        }

        $config->merge(new Config($data));
    }
}
