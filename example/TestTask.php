<?php

namespace Phalsion\Example;


use Phalcon\Mvc\Model;
use Phalsion\Example\app\User;
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
        $redis = $this->getDI()->get('redis');
        $redis->set('rpc_framework', '1');


//        $records = User::find();

//        return $this->response(sprintf("has %d records!", count($records)));
        return $this->response("hello world!");
    }
}
