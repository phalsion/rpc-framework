<?php

namespace Phalsion\RpcFramework\Bundle\FrameworkBundle\Task;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\AbstractBaseClass;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\Response;


/**
 * Class AbstractTask
 *
 * @author  liqi created_at 2017/10/18下午6:33
 * @package \Phalsion\RpcFramework\Component\BaseClass
 */
abstract class AbstractTask extends AbstractBaseClass implements TaskInterface
{
    private $_response;

    /**
     * @return \Phalsion\RpcFramework\Component\RpcKernel\Foundation\ResponseInterface
     */
    public function getResponse()
    {
        return Response::createResponse(
            $this->_response['code'],
            $this->_response['msg'],
            $this->_response['response'],
            $this->_response['flag']
        );
    }


    public function response( $response, $code = 0, $msg = '', $flag = 0 )
    {
        $this->_response = compact('response', 'code', 'msg', 'flag');

        return;
    }

}
