<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Di\ServiceProviderInterface;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;
use Phalsion\RpcFramework\Component\Router\HasRouteInterface;
use Phalsion\RpcFramework\Component\Router\RouterRegister;
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
    protected $router_register;
    protected $reloadBundles;

    /**
     * @var \Phalsion\RpcFramework\Component\Router\RouterInterface $router
     */
    protected $router;

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
    public function __construct( $environment, $debug, RouterRegister $router_register, Di $di )
    {
        $this->setDI($di);
        $this->environment     = $environment;
        $this->is_debug        = (bool) $debug;
        $this->booted          = false;
        $this->reloadBundles   = [];
        $this->router_register = $router_register;
    }


    public function reload()
    {
        foreach ( $this->reloadBundles as $bundle ) {
            $this->kernel_events_manager->fire(KernelEvents::RELOAD, $bundle, $this->getDI());
        }
    }

    public function boot()
    {
        //如果该方法已经被调用过，则直接返回
        if ( $this->booted ) {
            return;
        }
        $this->booted = true;
        if ( !$this->getDI()->has('console') ) {
            throw new RuntimeException("service 'console' not found.", -1);
        }

        if ( !$this->getDI()->has('kernelEventsManager') ) {
            throw new RuntimeException("service 'kernelEventsManager' not found.", -1);
        }
        $this->kernel_events_manager = $this->getDI()->get('kernelEventsManager');

        //注册bundle
        $this->initializeBundles();

        $this->router = $this->router_register->getRouter();
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
                    $this->kernel_events_manager->fire(KernelEvents::BOOTSTRAP, $bundle, $this->getDI());
                }

                if ( $bundle instanceof ReloadRegisterInterface ) {
                    $this->reloadBundles[] = $bundle;
                }

                if ( $bundle instanceof HasRouteInterface ) {
                    $this->router_register->register($bundle);
                }

                continue;
            }

            throw new \RuntimeException(sprintf('the bundle "%s" is not instanceof Phalcon\Di\ServiceProviderInterface, so it can not be register', $name));
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
