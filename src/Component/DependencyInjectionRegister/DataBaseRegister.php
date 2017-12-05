<?php

namespace Phalsion\RpcFramework\Component\DependencyInjectionRegister;

/**
 * Class DataBaseRegister
 *
 * @author  liqi created_at 2017/10/20上午11:44
 * @package \Phalsion\RpcFramework\Component\DependencyInjectionRegister
 */
class DataBaseRegister extends DiRegister
{
    public function register( \Phalcon\DiInterface $di )
    {
        $database_configs = $this->getParameter('database');

        foreach ( $database_configs as $name => $options ) {
            $this->getDI()->setShared($name, function () use ( $options ) {
                $class  = 'Phalcon\Db\Adapter\Pdo\\' . $options->adapter;
                $params = [
                    'host'     => $options->host,
                    'username' => $options->username,
                    'password' => $options->password,
                    'dbname'   => $options->dbname,
                    'charset'  => $options->charset
                ];

                if ( $options->adapter == 'Postgresql' ) {
                    unset($params['charset']);
                }

                $connection = new $class($params);

                return $connection;
            });
        }

    }

}
