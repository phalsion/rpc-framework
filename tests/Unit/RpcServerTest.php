<?php

namespace Tests\Unit;


use Phalsion\RpcFramework\Component\RpcKernel\Handable;
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
        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if ( !$client->connect('127.0.0.1', 9599, -1) ) {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send("hello world\r\n");
        $this->assertEquals("hello world\r\n", $client->recv());
        $client->close();
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
                return $data;
            }

            public function decode( $data )
            {
                return $data;
            }
        };
    }
}




