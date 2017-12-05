<?php

namespace Tests\Unit;


use Phalsion\RpcFramework\Component\Router\SimpleRouter;

class SimpleRouterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @group simpleRouter
     */
    public function testSimpleRouter()
    {
        $router = new SimpleRouter();

        $router->setRouterMap(
            [
                'test' => [
                    'action' => 'asd',
                    'task'   => 'xxx'
                ]
            ]
        );

        $r = $router->match([ 'method' => 'test' ]);

        $this->assertEquals([
                                'action' => 'asd',
                                'task'   => 'xxx'
                            ], $r);
    }


    /**
     * @group simpleRouter
     * @expectedException \Phalsion\RpcFramework\Component\Exception\RuntimeException
     */
    public function testError1SimpleRouter()
    {
        $router = new SimpleRouter();

        $router->setRouterMap(
            [
                'test' => [
                    'action' => 'asd',
                    ''       => 'xxx'
                ]
            ]
        );
    }

    /**
     * @group simpleRouter
     * @expectedException \Phalsion\RpcFramework\Component\Exception\RuntimeException
     */
    public function testError2SimpleRouter()
    {
        $router = new SimpleRouter();

        $router->setRouterMap(
            [
                '' => [
                    'action' => 'asd',
                    'task'   => 'xxx'
                ]
            ]
        );
    }


    /**
     * @group simpleRouter
     * @expectedException \Phalsion\RpcFramework\Component\Exception\NotFoundException
     */
    public function testError3SimpleRouter()
    {
        $router = new SimpleRouter();

        $router->setRouterMap(
            [
                'test' => [
                    'action' => 'asd',
                    'task'   => 'xxx'
                ]
            ]
        );

        $router->match([ 'method' => 'asd' ]);
    }


}
