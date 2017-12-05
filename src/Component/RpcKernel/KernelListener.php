<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Di;
use Phalcon\Events\Event;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;
use Phalsion\RpcFramework\Component\RpcKernel\Register\BootRegisterInterface as BootRegisters;
use Phalsion\RpcFramework\Component\RpcKernel\Register\ReloadRegisterInterface as ReloadRegisters;

/**
 * Class KernelListener
 *
 * @author  liqi created_at 2017/12/5上午10:57
 * @package \Phalsion\RpcFramework\Component\RpcKernel
 */
class KernelListener
{

    public function bootstrap( Event $event, BootRegisters $registers, Di $app )
    {
        /**
         * @var \Phalcon\Di\ServiceProviderInterface $register
         */
        foreach ( $registers->getBootRegister() as $register ) {
            if ( $register instanceof Di\ServiceProviderInterface )
                $app->register($register);
            else
                throw new RuntimeException(sprintf('\'%s\' is not instance of Di\ServiceProviderInterface', get_class($register)), -1);
        }
    }

    public function reload( Event $event, ReloadRegisters $registers, Di $app )
    {
        /**
         * @var \Phalcon\Di\ServiceProviderInterface $register
         */
        foreach ( $registers->getReloadRegister() as $register ) {
            if ( $register instanceof Di\ServiceProviderInterface )
                $app->register($register);
            else
                throw new RuntimeException(sprintf('\'%s\' is not instance of Di\ServiceProviderInterface', get_class($register)), -1);
        }
    }
}
