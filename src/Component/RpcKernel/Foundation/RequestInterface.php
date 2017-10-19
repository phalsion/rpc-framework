<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Foundation;

/**
 * Interface RequestInterface
 *
 * @author  liqi created_at 2017/10/18下午6:16
 * @package Phalsion\RpcFramework\Component\RpcKernel\Fundation
 */
interface RequestInterface extends \IteratorAggregate, \Countable
{

    /**
     * 获取当前路由名称
     * $router = [
     *      'demo'=>[
     *          'task'=>'xxx',
     *          'action'=>'xxx'
     *       ]
     * ]
     *  $request->currentRouter()//$router['demo']
     *
     * @return \Phalcon\Config
     */
    public function currentRouter();

    /**
     * 获取当前路由名称
     * $router = [
     *      'demo'=>[
     *          'task'=>'xxx',
     *          'action'=>'xxx'
     *       ]
     * ]
     *  $request->currentRouterName()//demo
     *
     * @return string
     */
    public function currentRouterName();


    public function session( $path, $defaultValue, $delimiter );


    public function match();

}
