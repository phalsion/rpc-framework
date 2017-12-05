<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Client;

/**
 * Interface ClientInterface
 *
 * @author  liqi created_at 2017/10/24上午10:24
 * @package Phalsion\RpcFramework\Component\RpcServer\Client
 */
interface ClientInterface
{
    /**
     * 进行远程调用
     *
     * @param string $method 远程调用的方法
     * @param array  $params 远程调用的参数
     * @param int    $flag   远程调用传入的参数
     *
     * @return mixed
     */
    public function call( $method, $params, $flag );

    /**
     * 设置需要链接
     *
     * @param string $conn 链接的名称
     *
     * @return mixed
     */
    public function connect( ClientParams $conn );


    /**
     * 在远程调用之后使用
     * 用于获取远程调用返回的状态码
     *
     * @return int|null
     */
    public function getCode();

    /**
     * 在远程调用之后使用
     * 用于获取远程调用返回的提示信息
     *
     * @return string|null
     */
    public function getMessage();
}
