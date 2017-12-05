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

    protected $router;

    /**
     * User: liqi
     * RouterRegister constructor.
     *
     * @param $router
     */
    public function __construct( RouterInterface $router ) { $this->router = $router; }

    public function register( HasRouteInterface $has_route )
    {
        foreach ( $has_route->getRouteMap() as $method => $payload ) {
            $this->router->attach($method, $payload);
        }
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
