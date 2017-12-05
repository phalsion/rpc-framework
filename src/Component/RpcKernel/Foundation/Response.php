<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Foundation;

/**
 * Class Response
 *
 * @author  liqi created_at 2017/10/18下午6:16
 * @package \Phalsion\RpcFramework\Component\RpcKernel\Fundation
 */
class Response implements ResponseInterface
{
    public $code;
    public $msg;
    public $data;
    public $flag;

    /**
     * @param $code
     * @param $msg
     * @param $data
     * @param $flag
     *
     * @return static
     */
    public static function createResponse( $code, $msg, $data, $flag )
    {
        $instance       = new static();
        $instance->code = $code;
        $instance->msg  = $msg;
        $instance->data = $data;
        $instance->flag = $flag;

        return $instance;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            $this->code,
            $this->data,
            $this->msg,
            $this->flag
        ];
    }
}
