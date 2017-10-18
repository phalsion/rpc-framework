<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Di\Injectable;
use Phalcon\Di\ServiceProviderInterface;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\FrameWorkBundle;
use Phalsion\RpcFramework\Component\RpcKernel\Fundation\RequestInterface;
use SebastianBergmann\GlobalState\RuntimeException;

/**
 * Class Kernel
 *
 * @author  liqi created_at 2017/10/18下午4:39
 * @package \Phalsion\RpcFramework\Component\RpcKernel
 */
abstract class Kernel extends Injectable implements KernelInterface
{

    const VERSION       = '2.0.0';
    const EXTRA_VERSION = 'beta';

    protected $is_debug;
    protected $environment;
    protected $startTime;
    protected $booted;
    protected $systemBundles;


    /**
     * 储存已经被注册过的bundle
     *
     * @var \Phalsion\RpcFramework\Component\RpcKernel\Bundle\BundleInterface[] $bundles
     */
    protected $bundles;

    /**
     * User: liqi
     * Kernel constructor.
     *
     * @param string  $environment
     * @param boolean $debug
     */
    public function __construct( $environment, $debug )
    {
        $this->environment = $environment;
        $this->is_debug    = (bool) $debug;
        $this->booted      = false;

        $this->systemBundles = [
            new FrameWorkBundle()
        ];

    }


    public function boot()
    {
        //如果改方法已经被调用过，则直接返回
        if ( $this->booted ) {
            return;
        }
        $this->booted = true;

        //注册bundle
        $this->initializeBundles();

    }

    /**
     * 处理请求
     *
     * @param string           $task
     * @param string           $action
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public function handle( $task, $action, RequestInterface $request )
    {
        $this->getDI()->set('request', $request);
        try {
            $response = $this->getDI()->get('console')->handle(compact('task', 'action'))->getResponse();
        } catch ( \Exception $exception ) {
            $response = null;
        }
        $this->getDI()->remove('request');

        return $response;
    }


    /**
     * 将各个bundle中的服务注册进Di容器
     *
     * @throws \LogicException 如果同名的bundle被注册2次
     * @throws \RuntimeException 如果bundle实例没有实现 Phalcon\Di\ServiceProviderInterface 接口
     */
    protected function initializeBundles()
    {
        $this->bundles = array();
        $bundles       = array_merge($this->registerSystemBundles(), $this->registerBundles());
        foreach ( $bundles as $bundle ) {
            $name = $bundle->getName();
            if ( isset($this->bundles[ $name ]) ) {
                throw new \LogicException(sprintf('名称为"%s"的bundle被注册了2次，请检查registerBundles中注册bundle是否重复！', $name));
            }

            if ( $bundle instanceof ServiceProviderInterface ) {
                $bundle->register($this->getDI());
                $this->bundles[ $name ] = $bundle;
            }

            throw new \RuntimeException(sprintf('名称为"%s"的bundle 必须实现 Phalcon\Di\ServiceProviderInterface接口才能被注册', $name));
        }
    }

    public function registerSystemBundles()
    {
        return $this->systemBundles;
    }


    public function getBundles()
    {
        return $this->bundles;
    }

    public function isDebug()
    {
        return $this->is_debug;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getStartTime()
    {
        return $this->debug ? $this->startTime : -INF;
    }


}
