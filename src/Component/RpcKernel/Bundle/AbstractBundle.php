<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Bundle;


use Phalcon\Di\ServiceProviderInterface;

/**
 * Class AbstractBundle
 *
 * @author  liqi created_at 2017/10/18下午7:07
 * @package \Phalsion\RpcFramework\Component\RpcKernel\Bundle
 */
abstract class AbstractBundle implements BundleInterface
{
    private $_di;

    public function getName()
    {
        return static::class;
    }

    public function register( \Phalcon\DiInterface $di )
    {
        $this->_di = $di;
        $this->boot();
    }

    public function getDI()
    {
        return $this->_di;
    }


}
