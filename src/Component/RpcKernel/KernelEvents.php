<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;

/**
 * Class KernelEvents
 *
 * @author  liqi created_at 2017/10/18下午4:40
 * @package \Phalsion\RpcFramework\Component\RpcKernel
 */
class KernelEvents
{
    const EVENT_TYPE = 'kernel';
    const BOOTSTRAP  = 'kernel:bootstrap';
    const RELOAD     = 'kernel:reload';
    const REQUEST    = 'kernel:request';
}
