<?php

namespace Phalsion\RpcFramework\Bundle\RedisBundle;


use Phalsion\RpcFramework\Bridge\Redis\RedisRegister;
use Phalsion\RpcFramework\Component\RpcKernel\Bundle\AbstractBundle;
use Phalsion\RpcFramework\Component\RpcKernel\Register\ReloadRegisterInterface;

/**
 * Class RedisBundle
 *
 * @author  liqi created_at 2017/12/5下午4:08
 * @package \Phalsion\RpcFramework\Bundle\RedisBundle
 */
class RedisBundle extends AbstractBundle implements ReloadRegisterInterface
{

    public function boot()
    {
    }

    public function getReloadRegister()
    {
        return [
            new RedisRegister()
        ];
    }
}
