<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Parser;

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
        return json_encode($data);
    }

    public function decode( $data )
    {
        return json_decode($data);
    }
}
