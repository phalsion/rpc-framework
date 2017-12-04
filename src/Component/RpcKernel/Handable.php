<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;

/**
 * Interface Handable
 *
 * @author  liqi created_at 2017/12/4下午2:54
 * @package Phalsion\RpcFramework\Component\RpcKernel
 */
interface Handable
{
    public function handle( $data );
}
