<?php

/**
 * client_test.php
 *
 * @author liqi created_at 2017/12/5下午3:10
 */


use Phalsion\RpcFramework\Component\RpcServer\Client\ClientParams;
use Phalsion\RpcFramework\Component\RpcServer\Client\RpcClient;
use Phalsion\RpcFramework\Component\RpcServer\Parser\JsonParser;

require __DIR__ . '/../vendor/autoload.php';


$client = new RpcClient(
    new JsonParser(),
    ClientParams::assign(
        SWOOLE_SOCK_TCP,
        SWOOLE_SOCK_SYNC,
        null,
        [
            'open_eof_check'     => true,
            'package_eof'        => "\r\n",
            'package_max_length' => 1024 * 1024 * 2,
        ],
        '127.0.0.1',
        '9501',
        0.5,
        0));

$d = $client->call('test', [ 'a' => 1 ]);

var_dump($d, $client->getMessage());
