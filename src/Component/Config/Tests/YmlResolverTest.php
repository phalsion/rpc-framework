<?php

namespace Phalsion\RpcFramework\Component\Config\Tests;


use Phalsion\RpcFramework\Component\Config\YmlResolver;

class YmlResolverTest extends \PHPUnit\Framework\TestCase
{

    /**
     * 测试yml解析模块中的'!php'函数
     */
    public function testResolve()
    {
        $resolver = new YmlResolver();
        $resolver->setRootPath(__DIR__ . '/_file/');
        $content  = $resolver->resolve(__DIR__ . '/_file/php.yml');
        var_dump($content);
    }

}
