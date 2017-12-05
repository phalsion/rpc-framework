<?php

namespace Phalsion\RpcFramework\Bundle\FrameworkBundle\Task;

/**
 * Interface TaskInterface
 *
 * @author  liqi created_at 2017/10/18下午6:36
 * @package Phalsion\RpcFramework\Component\BaseClass
 */
interface TaskInterface
{
    public function getResponse();

    public function response( $response, $code, $msg, $flag );
}
