<?php

namespace Phalsion\RpcFramework\Bundle\FrameworkBundle;


use Phalsion\RpcFramework\Bridge\Redis\RedisRegister;
use Phalsion\RpcFramework\Component\DependencyInjectionRegister\DataBaseRegister;
use Phalsion\RpcFramework\Component\Router\RouterRegister;
use Phalsion\RpcFramework\Component\RpcKernel\Bundle\AbstractBundle;
use Phalsion\RpcFramework\Component\RpcKernel\KernelEvents;
use Phalsion\RpcFramework\Component\RpcKernel\KernelListener;
use Phalsion\RpcFramework\Component\RpcKernel\Register\BootRegisterInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Register\ReloadRegisterInterface;

/**
 * Class FrameWorkBundle
 *
 * @author  liqi created_at 2017/10/18下午7:21
 * @package \Phalsion\RpcFramework\Bundle\FrameworkBundle
 */
class FrameWorkBundle extends AbstractBundle implements ReloadRegisterInterface, BootRegisterInterface
{

    public function boot()
    {
        $events_manager  = $this->getDI()->get('kernelEventsManager');
        $kernel_listener = new KernelListener();
        $events_manager->attach(KernelEvents::EVENT_TYPE, $kernel_listener);
    }

    public function getBootRegister()
    {
        return [
        ];
    }

    public function getReloadRegister()
    {
        return [
        ];
    }
}
