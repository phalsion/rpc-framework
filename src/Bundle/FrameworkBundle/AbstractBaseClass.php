<?php

namespace Phalsion\RpcFramework\Component\BaseClass;


use Phalcon\Di\Injectable;

/**
 * Class AbstractBaseClass
 *
 * @author  liqi created_at 2017/10/18下午6:35
 * @package \Phalsion\RpcFramework\Component\BaseClass
 */
abstract class AbstractBaseClass extends Injectable
{
    public function Di( $name, $parameters = null )
    {
        $this->getDI()->get($name, $parameters);
    }
}
