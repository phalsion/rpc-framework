<?php

namespace Phalsion\RpcFramework\Component\BaseClass;


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
        return $this->_response;
    }


    public function response( $response, $code = null, $msg = '', $flag = 0 )
    {
        $this->_response = compact('response', 'code', 'msg', 'flag');

        return;
    }

}
