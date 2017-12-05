<?php

namespace Phalsion\RpcFramework\Component\Config;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YmlResolver
 *
 * @author  liqi created_at 2017/10/19上午10:27
 * @package \Phalsion\RpcFramework\Component\FileLoader
 */
class YmlResolver implements ConfigFileResolver
{

    protected $kernel;

    protected $resolved;

    protected $root_path;

    public function __construct()
    {
        $this->resolved = [];
    }

    public function resolve( $path )
    {
        if ( substr($path, 0, 1) != '/' ) {
            $path = $this->getRootPath() . $path;
        }
        //如果文件已经被加载过直接获取该文件的配置
        if ( array_key_exists($path, $this->resolved) ) {
            return $this->resolved[ $path ];
        }

        $content                 = Yaml::parse(file_get_contents($path));
        $this->resolved[ $path ] = $content;

        if ( !$content ) {
            return $content;
        }

        if ( array_key_exists('imports', $content) ) {
            $imports = $content['imports'];
            if ( !is_array($imports) ) {
                throw new RuntimeException('imports的值必须是数组！', ErrorCode::FAIL);
            }

            foreach ( $imports as $import ) {
                $sub_path = $import['resource'] ?? null;
                if ( !$sub_path ) {
                    throw new RuntimeException('请检查imports下是否设置了正确的resource属性！');
                }
                $sub_content = $this->resolve($sub_path);
                $content     = array_merge($content, $sub_content);
            }

        }

        array_walk_recursive($content, function ( &$element, $key, $resolve ) {
            if ( !is_string($element) ) {
                return;
            }

            if ( strpos($element, '!') === false ) {
                return;
            }


            if ( strpos($element, '!php') === 0 ) {
                $element = str_replace('!php', '', $element);
                $element = $resolve->phpFunction($element);

                return;
            }

            if ( strpos($element, '!env') === 0 ) {
                $element = str_replace('!env', '', $element);
                $element = $resolve->envFunction($element);

                return;
            }

//            if ( strpos($element, '!config') == 0 ) {
//                $element = str_replace('!config', '', $element);
//                $element = $resolve->configFunction($element);
//
//                return;
//            }

        }, $this);

        return $content;
    }


    public function phpFunction( $code )
    {
        return eval("return " . $code . ";");
    }


    public function envFunction( $path )
    {
        return env(trim($path));
    }

    public function setRootPath( $root_path )
    {
        $this->root_path = $root_path;
    }

    public function getRootPath()
    {
        return $this->root_path;
    }


}
