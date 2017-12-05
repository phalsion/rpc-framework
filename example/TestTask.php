<?php

namespace Phalsion\Example;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\Task\AbstractTask;

/**
 * Class TestTask
 *
 * @author  liqi created_at 2017/12/5下午3:05
 * @package \Phalsion\Example
 */
class TestTask extends AbstractTask
{
    public function indexAction()
    {
        return $this->response("hello world!");
    }
}
