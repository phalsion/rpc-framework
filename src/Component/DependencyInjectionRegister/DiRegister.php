<?php

namespace Phalsion\RpcFramework\Component\DependencyInjectionRegister;


use Phalsion\RpcFramework\Component\Config\Config;
use Phalsion\RpcFramework\Component\RpcKernel\KernelInterface;

/**
 * Class DiRegister
 *
 * @author  liqi created_at 2017/10/19下午1:21
 * @package \Phalsion\RpcFramework\Component\DependencyInjectionRegister
 */
abstract class DiRegister implements DiRegisterInterface
{
    protected $kernel;

    public function __construct( KernelInterface $kernel )
    {
        $this->kernel = $kernel;
    }

    protected function getDI()
    {
        return $this->kernel->getDI();
    }

    protected function getParameter( $key )
    {
        return $this->getDI()->get('config')->get($key);
    }

}
