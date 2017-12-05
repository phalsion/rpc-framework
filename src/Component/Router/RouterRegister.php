<?php

namespace Phalsion\RpcFramework\Component\Router;

/**
 * Class RouterRegister
 *
 * @author  liqi created_at 2017/12/5下午1:07
 * @package \Phalsion\RpcFramework\Component\Router
 */
class RouterRegister implements RouterRegisterInterface
{

    /**
     * @var array $routers
     */
    public $routers;

    public function register( RouterAttacherInterface $router )
    {
        foreach ( $this->routers as $m => $r ) {
            $router->attach($m, $r);
        }
    }
}
