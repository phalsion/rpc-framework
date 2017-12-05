<?php

namespace Phalsion\RpcFramework\Component\RpcServer\Client;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\Exception\AppException;
use Phalsion\RpcFramework\Component\RpcServer\Parser\ParserInterface;

/**
 * Class RpcClient
 *
 * @author  liqi created_at 2017/10/18下午7:40
 * @package \Phalsion\RpcFramework\Component\RpcServer\Client
 */
class RpcClient implements ClientInterface
{

    /**
     * 异常错误码
     * 当错误抛出异常的时候使用
     */
    const ERR_TIMEOUT = 9991;//等待超时
    const ERR_CONNECT = 9992;//链接失败
    const ERR_SEND    = 9993;//发送失败
    const ERR_PORT    = 9994;//未配置的接口

    /**
     * @var \swoole_client $client
     */
    protected $client;
    protected $parser;
    protected $code;
    protected $message;
    protected $time_out;
    protected $eof;


    public function __construct( ParserInterface $parser, ClientParams $params )
    {
        $this->code    = null;
        $this->message = null;
        $this->parser  = $parser;
        $this->client  = $this->bootstrap($params);
        $this->connect($params);
    }


    protected function bootstrap( ClientParams $params )
    {
        $client    = new \swoole_client($params->sock_type, $params->is_sync, $params->key);
        $this->eof = $params->setting['package_eof'];
        $client->set($params->setting);

        return $client;
    }

    /**
     * @inheritdoc
     */
    public function call( $method, $params, $flag = null )
    {
        //判断与服务端链接是否成功
        if ( !$this->isConnected() ) {
            throw new AppException('client connect error', static::ERR_CONNECT);
        }

        //通信逻辑为客户端请求->服务端应答
        //在客户端请求之前需要确认已经向服务端成功发送数据
        if ( !$this->client->send($this->getParser()->encode(compact('method', 'params', 'flag'))) ) {
            //发送数据失败
            throw new AppException('client send data error:', static::ERR_SEND);
        }

        $msg  = '';
        $time = microtime(true);
        //当数据发送成功等待数据返回
        while ( 1 ) {
            if ( microtime(true) - $time > $this->time_out ) {
                throw new AppException('client timeout', static::ERR_TIMEOUT);
            }
            $m = $this->client->recv();
            if ( $m === false ) {
                //等待数据超时
                throw new AppException('client timeout', static::ERR_TIMEOUT);
            }
            $msg .= $m;

            $start = strlen($this->getEof());
            if ( $this->getEof() == substr($msg, -$start, $start) ) {
                break;
            }
        }


        $response = $this->parser->decode($msg);
        //设置返回码和信息
        $this->code    = $response[0];
        $this->message = $response[2];
        return $response[1];
    }

    /**
     * @inheritdoc
     */
    public function connect( ClientParams $params )
    {
        if ( $this->isConnected() ) {
            $this->close();
        }
        $this->time_out = 1000 * $params->timeout;

        return $this->client->connect($params->address, $params->port, $params->timeout, $params->flag);
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function isConnected()
    {
        return $this->client->isConnected();
    }

    public function close()
    {
        return $this->client->close();
    }


    /**
     * @return \swoole_client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * User: liqi
     * Date: 2016.8.13
     *
     * @param \swoole_client $client
     */
    public function setClient( $client )
    {
        $this->client = $client;
    }

    /**
     * @return \Phalsion\RpcFramework\Component\RpcServer\Parser\ParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * User: liqi
     * Date: 2016.8.13
     *
     * @param \Phalsion\RpcFramework\Component\RpcServer\Parser\ParserInterface $parser
     */
    public function setParser( $parser )
    {
        $this->parser = $parser;
    }

    /**
     * @return mixed
     */
    public function getEof()
    {
        return $this->eof;
    }

    /**
     * User: liqi
     * Date: 2016.8.13
     *
     * @param mixed $eof
     */
    public function setEof( $eof )
    {
        $this->eof = $eof;
    }

}
