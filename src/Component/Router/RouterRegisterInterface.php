<?php

namespace Phalsion\RpcFramework\Component\Router;

/**
 * Class RouterRegisterInterface
 *
 * @author  liqi created_at 2017/12/5上午11:58
 * @package \Phalsion\RpcFramework\Component\Router
 */
interface RouterRegisterInterface
{
    public function register( RouterAttacherInterface $router );
}
