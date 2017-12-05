<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Parser;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\Exception\AppException;

/**
 * Class JsonParser
 *
 * @author  liqi created_at 2017/10/18下午7:41
 * @package \Phalsion\RpcFramework\Component\RpcServer\Parser
 */
class JsonParser implements ParserInterface
{
    public function encode( $data )
    {
        return json_encode($data) ."\r\n";
    }

    public function decode( $data )
    {
        $dec = json_decode($data, true);
        if ( $dec === null ) {
            throw new AppException('client decode error:' . $data, 9995);
        }

        return $dec;
    }
}
