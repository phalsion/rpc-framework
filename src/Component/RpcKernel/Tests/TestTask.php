<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Tests;

use Phalsion\RpcFramework\Bundle\FrameworkBundle\Task\AbstractTask;


/**
 * Class TestTask
 *
 * @author  liqi created_at 2017/12/5上午8:06
 */
class TestTask extends AbstractTask
{

    public function indexAction()
    {
        return $this->response("hello world");
    }
}
