<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Config\Adapter\Ini;
use Phalcon\Di\Injectable;
use Phalcon\Di\ServiceProviderInterface;
use Phalsion\RpcFramework\Bundle\DebugBundle\DebugBundle;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\FrameWorkBundle;
use Phalsion\RpcFramework\Component\Config\ConfigLoaderInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\RequestBuilder;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\RequestInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\Response;

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

        $this->systemBundles[] = new FrameWorkBundle();

        if ( $this->is_debug ) {
            $this->systemBundles[] = new DebugBundle();
        }

    }


    public function reload()
    {

    }

    public function boot()
    {
        //如果该方法已经被调用过，则直接返回
        if ( $this->booted ) {
            return;
        }
        $this->booted = true;

        //注册bundle
        $this->initializeBundles();

    }

    public function loadConfig( ConfigLoaderInterface $config_loader )
    {
        //先加载env.ini
        $this->getDI()->setShared('env', new Ini($this->getRootDir() . '/env.ini'));

        //加载框架配置项
        $path = "config_" . $this->getEnvironment() . '.yml';
        if ( !file_exists($this->getRootDir() . '/config/' . $path) ) {
            $path = "config_" . $this->getEnvironment() . '.php';
        }
        $config_loader->setRootPath($this->getRootDir() . '/config/');
        $config_loader->load($path);
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
    public function handle( $data )
    {
        //创建请求对象
        $request = RequestBuilder::createFromData($data);
        $this->getDI()->set('request', $request);
        try {
            //处理请求获取返回信息
            $response = $this->getDI()->get('console')->handle($request->match())->getResponse();
        } catch ( \Exception $exception ) {
            $response = Response::createResponse(ErrorCode::FAIL, $exception->getMessage(), null, 0);
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
