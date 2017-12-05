<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Config\Adapter\Ini;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Di\ServiceProviderInterface;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Component\Config\ConfigLoaderInterface;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;
use Phalsion\RpcFramework\Component\Router\RouterInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\RequestBuilder;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\RequestInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Foundation\Response;
use Phalsion\RpcFramework\Component\RpcKernel\Register\BootRegisterInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Register\ReloadRegisterInterface;

/**
 * Class Kernel
 *
 * @author  liqi created_at 2017/10/18下午4:39
 * @package \Phalsion\RpcFramework\Component\RpcKernel
 */
abstract class Kernel extends Injectable implements KernelInterface
{

    const VERSION       = '0.1.0';
    const EXTRA_VERSION = 'beta';

    protected $is_debug;
    protected $environment;
    protected $startTime;
    protected $booted;
    protected $router;
    protected $app;
    protected $reloadBundles;


    /**
     * 储存已经被注册过的bundle
     *
     * @var \Phalsion\RpcFramework\Component\RpcKernel\Bundle\BundleInterface[] $bundles
     */
    protected $bundles;


    /**
     * @var \Phalcon\Events\Manager $kernel_events_manager
     */
    protected $kernel_events_manager;

    /**
     * User: liqi
     * Kernel constructor.
     *
     * @param string  $environment
     * @param boolean $debug
     */
    public function __construct( $environment, $debug, ConfigLoaderInterface $config_loader, RouterInterface $router, Di $app )
    {
        $this->app = $app;
        $this->setDI($app);
        $this->environment = $environment;
        $this->is_debug    = (bool) $debug;
        $this->booted      = false;
        $this->loadConfig($config_loader);
        $this->router = $router;
    }


    public function reload()
    {
        foreach ( $this->reloadBundles as $bundle ) {
            $this->kernel_events_manager->fire(KernelEvents::RELOAD, $bundle, $this->app);
        }
    }

    public function boot()
    {
        //如果该方法已经被调用过，则直接返回
        if ( $this->booted ) {
            return;
        }
        $this->booted = true;
        if ( !$this->app->has('console') ) {
            $this->app->set('console', $this->app);
        }

        if ( !$this->app->has('kernelEventsManager') ) {
            throw new RuntimeException("'kernelEventsManager' not found. please add FrameWorkBundle", -1);
        }
        $this->kernel_events_manager = $this->app->get('kernelEventsManager');

        //注册bundle
        $this->initializeBundles();
    }

    public function loadConfig( ConfigLoaderInterface $config_loader )
    {
        //先加载env.ini
        $this->getDI()->setShared('env', new Ini($this->getRootDir() . '/env.ini'));

        //加载框架配置项
        $path = "config_" . $this->getEnvironment() . '.yml';
        $file = $this->getRootDir() . '/config/' . $path;
//        if ( !file_exists($file) ) {
//            $file = "config_" . $this->getEnvironment() . '.php';
//        }
        $config_loader->load($file);
    }


    /**
     * 处理请求
     *
     * @param string           $task
     * @param string           $action
     * @param RequestInterface $request
     *
     * @return
     */
    public function handle( $data )
    {
        try {
            $match_router   = $this->router->match($data);
            $data['router'] = $match_router;
            //创建请求对象
            $request = RequestBuilder::createFromData($data);
            $this->getDI()->set('request', $request);
            //处理请求获取返回信息
            $response = $this->getDI()
                ->get('console')
                ->handle($request->match())
                ->getResponse();
            $this->getDI()->remove('request');
        } catch ( \Exception $exception ) {
            $response = Response::createResponse(ErrorCode::FAIL, $exception->getMessage(), null, 0);
        }

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
        $bundles       = $this->registerBundles();
        foreach ( $bundles as $bundle ) {
            $name = $bundle->getName();
            if ( isset($this->bundles[ $name ]) ) {
                throw new \LogicException(sprintf('名称为"%s"的bundle被注册了2次，请检查registerBundles中注册bundle是否重复！', $name));
            }

            if ( $bundle instanceof ServiceProviderInterface ) {
                $bundle->register($this->getDI());
                $this->bundles[ $name ] = $bundle;
                if ( $bundle instanceof BootRegisterInterface ) {
                    $this->kernel_events_manager->fire(KernelEvents::BOOTSTRAP, $bundle, $this->app);
                }

                if ( $bundle instanceof ReloadRegisterInterface ) {
                    $this->reloadBundles[] = $bundle;
                }
            }

            throw new \RuntimeException(sprintf('名称为"%s"的bundle 必须实现 Phalcon\Di\ServiceProviderInterface接口才能被注册', $name));
        }
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
