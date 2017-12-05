<?php

namespace Phalsion\RpcFramework\Bundle\FrameworkBundle\Repository;


use Phalcon\Mvc\Model as Entity;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\AbstractBaseClass;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\Exception\AppException;

/**
 * Class AbstractRepository
 *
 * @author  liqi created_at 2017/10/18下午6:33
 * @package \Phalsion\RpcFramework\Component\BaseClass
 */
abstract class AbstractRepository extends AbstractBaseClass
{
    private $_entity;

    public function getEntity()
    {
        return $this->_entity;
    }

    public function setEntity( $entity )
    {
        $this->_entity = $entity;
    }
}
