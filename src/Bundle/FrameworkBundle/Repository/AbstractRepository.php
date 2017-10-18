<?php

namespace Phalsion\RpcFramework\Component\BaseClass;


use Phalcon\Mvc\Model as Entity;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\Exception\AppException;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\Repository\RepositoryInterface;

/**
 * Class AbstractRepository
 *
 * @author  liqi created_at 2017/10/18下午6:33
 * @package \Phalsion\RpcFramework\Component\BaseClass
 */
abstract class AbstractRepository extends AbstractBaseClass implements RepositoryInterface
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

    public function newEntity()
    {
        return $this->Di($this->getEntityName());
    }

    public function persistEntity( Entity $entity )
    {
        if ( false == $entity->save() ) {
            throw new AppException(
                '保存失败！',
                ErrorCode::FAIL
            );
        }

        return true;
    }


}
