<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Foundation;


use Traversable;


/**
 * Class Request
 *
 * @author  liqi created_at 2017/10/18下午6:15
 * @package \Phalsion\RpcFramework\Component\RpcKernel\Fundation
 */
class Request implements RequestInterface
{

    public $params;
    public $router;
    public $routerName;
    public $session;

    public function __construct( $router, $router_name, $params, $session )
    {
        $this->params     = $params;
        $this->router     = $router;
        $this->routerName = $router_name;
        $this->session    = $session;
    }


    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->params);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->params);
    }

    /**
     * @inheritdoc
     */
    public function currentRouter()
    {
        return $this->router;
    }

    /**
     * @inheritdoc
     */
    public function currentRouterName()
    {
        return $this->routerName;
    }

    public function session( $path, $defaultValue, $delimiter )
    {

    }

    public function match()
    {
        $router = $this->currentRouter();

        return [
            'task'   => $router['task'],
            'action' => $router['action']
        ];
    }
}
