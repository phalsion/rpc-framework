<?php

namespace Phalsion\RpcFramework\Component\RpcServer;


use Phalsion\RpcFramework\Component\RpcKernel\Handable;
use Phalsion\RpcFramework\Component\RpcKernel\Reloadable;
use Phalsion\RpcFramework\Component\RpcServer\Parser\ParserInterface;

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
    protected $parser;
    protected $is_debug;

    public function __construct( Handable $kernel, ParserInterface $parser, ServerParams $params )
    {
        $this->server   = $this->bootstrap($params);
        $this->kernel   = $kernel;
        $this->parser   = $parser;
        $this->is_debug = $params->is_debug;
    }

    protected function bootstrap( ServerParams $params )
    {
        $server = new \swoole_server($params->address, $params->port, $params->model, $params->socket_type);
        $server->set($params->setting);

        return $server;
    }


    public function onWorkerStart( $serv, $worker_id )
    {
        if ( $worker_id >= $serv->setting['worker_num'] ) {
        } else {
            if ( $this->kernel instanceof Reloadable )
                $this->kernel->reload();
        }
    }

    public function onReceive( \swoole_server $server, $fd, $reactor_id, $origin_data )
    {
        $data     = $this->parser->decode($origin_data);
        $response = $this->kernel->handle($data);

        $server->send($fd, $this->parser->encode($response));
    }


    public function serve()
    {
        $this->server->on('WorkerStart', [ $this, 'onWorkerStart' ]);
        $this->server->on('Receive', [ $this, 'onReceive' ]);
        $this->server->start();
    }


}
