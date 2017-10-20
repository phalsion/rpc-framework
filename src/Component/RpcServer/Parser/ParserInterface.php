<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Parser;

/**
 * Interface ParserInterface
 *
 * @author  liqi created_at 2017/10/20上午10:31
 * @package Phalsion\RpcFramework\Component\RpcServer\Parser
 */
interface ParserInterface
{
    public function encode( $data);

    public function decode($data);
}
