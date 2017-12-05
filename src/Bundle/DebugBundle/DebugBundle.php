<?php

namespace Phalsion\RpcFramework\Bundle\DebugBundle;


use Phalsion\RpcFramework\Component\RpcKernel\Bundle\AbstractBundle;

/**
 * Class DebugBundle
 *
 * @author  liqi created_at 2017/10/19上午10:47
 * @package \Phalsion\RpcFramework\Bundle\DebugBundle
 */
class DebugBundle extends AbstractBundle
{

    public function boot()
    {
        require __DIR__ . "/foundation.php";
    }
}
