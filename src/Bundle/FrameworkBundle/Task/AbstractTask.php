<?php

namespace Phalsion\RpcFramework\Component\BaseClass;


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

    public function getResponse()
    {
        return Response::createResponse(
            $this->_response['code'],
            $this->_response['data'],
            $this->_response['msg'],
            $this->_response['flag']
        );
    }


    public function response( $response, $code = null, $msg = '', $flag = 0 )
    {
        $this->_response = compact('response', 'code', 'msg', 'flag');

        return;
    }

}
