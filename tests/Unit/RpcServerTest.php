<?php

namespace Tests\Unit;


use Phalsion\RpcFramework\Component\RpcKernel\Handable;
use Phalsion\RpcFramework\Component\RpcServer\Client\ClientParams;
use Phalsion\RpcFramework\Component\RpcServer\Client\RpcClient;
use Phalsion\RpcFramework\Component\RpcServer\Parser\ParserInterface;
use Phalsion\RpcFramework\Component\RpcServer\RpcServer;
use Phalsion\RpcFramework\Component\RpcServer\ServerParams;
use swoole_client;

class RpcServerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @group server
     */
    public function testServer()
    {
        $server = new RpcServer(
            $this->getTestHandler(),
            $this->getTestParser(),
            ServerParams::assign("127.0.0.1", '9599', SWOOLE_PROCESS, SWOOLE_SOCK_TCP,
                                 [
                                     'worker_num'     => 4,
                                     'open_eof_check' => true, //打开EOF检测
                                     'package_eof'    => "\r\n", //设置EOF
                                 ])
        );

        $server->serve();
    }

    /**
     * @group client
     */
    public function testClient()
    {
        $client = new RpcClient($this->getTestParser(), ClientParams::assign(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC, null,
                                                                             [
                                                                                 'open_eof_check'     => true,
                                                                                 'package_eof'        => "\r\n",
                                                                                 'package_max_length' => 1024 * 1024 * 2,
                                                                             ],
                                                                             '127.0.0.1',
                                                                             '9599',
                                                                             0.5, 0));

        $d = $client->call('asd', [ 'a' => 1 ]);
        $this->assertEquals("hello world\r\n", $d);
    }

    public function getTestHandler()
    {
        return new class implements Handable
        {

            public function handle( $data )
            {
                return "hello world\r\n";
            }
        };
    }


    public function getTestParser()
    {
        return new class implements ParserInterface
        {

            public function encode( $data )
            {
                if ( is_array($data) ) {
                    return json_encode($data);
                }

                return $data;
            }

            public function decode( $data )
            {
                if ( json_decode($data) ) {
                    return json_decode($data);
                } else {
                    return [ 'code' => 0, 'data' => $data, 'msg' => '' ];
                }
            }
        };
    }
}




