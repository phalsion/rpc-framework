<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Client;

/**
 * Class RpcClient
 *
 * @author  liqi created_at 2017/10/18下午7:40
 * @package \Phalsion\RpcFramework\Component\RpcServer\Client
 */
class RpcClient implements ClientInterface
{
    /**
     * 控制当客户端遇到错误时的行为。
     * E_EXCEPTION 当遇到错误时抛出异常
     * E_RETURN 当遇到错误时立刻返回false
     */
    const E_EXCEPTION = 1;
    const E_RETURN    = 2;

    /**
     * 异常错误码
     * 当错误抛出异常的时候使用
     */
    const ERR_TIMEOUT = 9991;//等待超时
    const ERR_CONNECT = 9992;//链接失败
    const ERR_SEND    = 9993;//发送失败
    const ERR_PORT    = 9994;//未配置的接口


    protected $time_out;

    protected $setting;

    protected $parser;

    protected $code;

    protected $message;

    protected $flag;

    protected $default_conn;

    protected $now_port;

    public function __construct()
    {
        $this->code         = null;
        $this->message      = null;
        $this->default_conn = 'default';
    }

    /**
     * @inheritdoc
     */
    public function call( $method, $params, $flag )
    {
        /**
         * 设置参数
         */
        $this->flag = $flag;

        /**
         * 在调用前贤判断是否指定了链接名称，如果没有指定
         * 将会调用default_port的值作为链接名称
         */
        if ( !$this->isConnected() ) {
            $this->connect($this->default_conn);
        }

        //判断与服务端链接是否成功
        if ( !$this->isConnected() ) {
            //客户端链接资源服务器失败
            $this->error(self::ERR_CONNECT);
        }

        //通信逻辑为客户端请求->服务端应答
        //在客户端请求之前需要确认已经向服务端成功发送数据
        if ( !$this->client->send($this->getParser()->encode($method, $params) . $this->getEof()) ) {
            //发送数据失败
            $this->error(self::ERR_SEND);
        }
        $msg  = '';
        $time = microtime(true);
        //当数据发送成功等待数据返回
        while ( 1 ) {
            if ( microtime(true) - $time > $this->time_out ) {
                $this->error(self::ERR_TIMEOUT);
            }
            $msg .= $this->client->recv();
            if ( $msg === false ) {
                //等待数据超时
                $this->error(self::ERR_TIMEOUT);
            }
            $start = strlen($this->getEof());
            if ( $this->getEof() == substr($msg, -$start, $start) ) {
                break;
            }
        }


        $response = $this->parser->decode($msg);
        //设置返回码和信息
        $this->setCode($response['code']);
        $this->setMessage($response['msg']);

        return $response['data'];
    }

    /**
     * @inheritdoc
     */
    public function connect( $conn )
    {
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
    }
}
