<?php


use Phalsion\RpcFramework\Component\RpcServer\ServerParams;
use \Phalcon\Cli\Console as App;
use \Phalcon\Di\FactoryDefault\Cli as Di;
use \Phalcon\Events\Manager as EventsManager;
use \Phalsion\RpcFramework\Component\Config\ConfigLoader;
use \Phalsion\RpcFramework\Component\Router\SimpleRouter;
use \Phalsion\RpcFramework\Component\Router\RouterRegister;
use \Phalsion\Example\App\AppKernel;
use \Phalsion\RpcFramework\Component\RpcServer\RpcServer;
use \Phalsion\RpcFramework\Component\RpcServer\Parser\JsonParser;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$di  = new Di();
$app->setDI($di);
$di->set('console', $app);
$kernel_events_manager = new EventsManager();
$di->set('kernelEventsManager', $kernel_events_manager);
$config_loader   = new ConfigLoader(__DIR__ . '/app/config/config.yml');
$router_register = new RouterRegister(new SimpleRouter());
$kernel          = new AppKernel('test', true, $router_register, $di);
$di->set('kernel', $kernel);
$kernel->boot();
$server_config = $di->get('config')->get('server');
$rpc_server    = new RpcServer(
    $kernel, new JsonParser(),
    ServerParams::assign(
        $server_config['address'],
        $server_config['port'],
        $server_config['model'],
        $server_config['socket_type'],
        $server_config['setting']->toArray()
    ));

$rpc_server->serve();

