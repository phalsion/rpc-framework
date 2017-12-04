<?php

namespace Phalsion\RpcFramework\Component\RpcServer;

/**
 * Class ServerParams
 *
 * @author  liqi created_at 2017/12/4下午3:00
 * @package \Phalsion\RpcFramework\Component\RpcServer
 */
class ServerParams
{
    public $address;
    public $port;
    public $model;
    public $socket_type;
    public $setting;
    public $is_debug;

    /**
     * User: liqi
     * ServerParams constructor.
     *
     * @param $address
     * @param $port
     * @param $model
     * @param $socket_type
     * @param $setting
     */
    public function __construct( $address, $port, $model, $socket_type, array $setting, $is_debug )
    {
        $this->address     = $address;
        $this->port        = $port;
        $this->model       = $model;
        $this->socket_type = $socket_type;
        $this->setting     = $setting;
        $this->is_debug    = boolval($is_debug);
    }


    public static function assign( $address, $port, $model, $socket_type, array $setting, $is_debug = false )
    {
        return new static($address, $port, $model, $socket_type, $setting, $is_debug);
    }

}
