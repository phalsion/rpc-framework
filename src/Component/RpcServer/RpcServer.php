<?php

namespace Phalsion\RpcFramework\Component\RpcServer;


use Phalsion\RpcFramework\Component\Exception\RuntimeException;
use Phalsion\RpcFramework\Component\RpcKernel\KernelInterface;

/**
 * Class RpcServer
 *
 * @author  liqi created_at 2017/10/18下午7:16
 * @package \Phalsion\RpcFramework\Component\RpcServer
 */
class RpcServer
{

    protected $server;
    protected $kernel;

    public function __construct( $name = 'default' )
    {
        $port_path = sprintf('swoole.ports.%s.', $name);
        if ( !conf($port_path) ) {
            throw new RuntimeException(sprintf('未找到%s的server配置项!', $name));
        }
        $address     = conf($port_path . 'address');
        $port        = conf($port_path . 'port');
        $model       = conf($port_path . 'model');
        $socket_type = conf($port_path . 'socket_type');
        $setting     = conf($port_path . 'setting')->toArray();

        $this->server = new \swoole_server($address, $port, $model, $socket_type);
        $this->server->set($setting);
    }

    public function onWorkerStart( $serv, $worker_id )
    {
        if ( $worker_id >= $serv->setting['worker_num'] ) {
        } else {
            $this->kernel->reload();
        }
    }

    public function onReceive( \swoole_server $server, $fd, $reactor_id, $origin_data )
    {
        $data     = $origin_data;
        $response = $this->kernel->handle($data);

        $server->send($fd, $response);
    }


    public function serve( KernelInterface $kernel )
    {
        $this->kernel = $kernel;
        $this->server->on('WorkerStart', [ $this, 'onWorkerStart' ]);
        $this->server->on('Receive', [ $this, 'onReceive' ]);
        $this->server->start();
    }


}
