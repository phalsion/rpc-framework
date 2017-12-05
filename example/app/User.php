<?php

namespace Phalsion\Example\app;

use Phalsion\RpcFramework\Bundle\FrameworkBundle\Model\AbstractModel;

/**
 * Class User
 *
 * @author  liqi created_at 2017/12/5下午4:26
 * @package \Phalsion\Example\app
 */
class User extends AbstractModel
{
    public function initialize(){
        $this->setSource('users');
    }
}
