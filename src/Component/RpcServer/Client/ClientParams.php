<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Client;

/**
 * Class ClientParams
 *
 * @author  liqi created_at 2017/12/4下午3:46
 * @package \Phalsion\RpcFramework\Component\RpcServer\Client
 */
class ClientParams
{
    public $sock_type;
    public $is_sync;
    public $key;
    public $address;
    public $port;
    public $timeout;
    public $flag;
    public $setting;

    public function __construct( $sock_type, $is_sync, $key, $setting, $address, $port, $timeout, $flag )
    {
        $this->sock_type = $sock_type;
        $this->is_sync   = $is_sync;
        $this->key       = $key;
        $this->setting   = $setting;
        $this->address   = $address;
        $this->port      = $port;
        $this->timeout   = $timeout;
        $this->flag      = $flag;
    }

    public static function assign( $sock_type, $is_sync, $key, $setting, $address, $port, $timeout, $flag )
    {
        return new static($sock_type, $is_sync, $key, $setting, $address, $port, $timeout, $flag);
    }

    public static function assignConn( $address, $port, $timeout, $flag )
    {
        return new static(null, null, null, null, $address, $port, $timeout, $flag);
    }


}
