<?php

namespace Phalsion\RpcFramework\Bundle\DataBaseBundle;


use Phalsion\RpcFramework\Component\DependencyInjectionRegister\DataBaseRegister;
use Phalsion\RpcFramework\Component\RpcKernel\Bundle\AbstractBundle;
use Phalsion\RpcFramework\Component\RpcKernel\Register\ReloadRegisterInterface;

/**
 * Class DataBaseBundle
 *
 * @author  liqi created_at 2017/12/5下午4:06
 * @package \Phalsion\RpcFramework\Bundle\DataBaseBundle
 */
class DataBaseBundle extends AbstractBundle implements ReloadRegisterInterface
{

    public function boot()
    {
    }

    public function getReloadRegister()
    {
        return [
            new DataBaseRegister()
        ];
    }
}
