<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\NotFoundApiException;

/**
 * api 仓库管理器
 *  - 查找api接口请求执行的class
 *  - 格式化api接口响应结果
 *
 * api仓库管理方式
 *  - 指定api仓库所在的namespace和dir（dir应该就是namespace所在的dir）
 *  - 在指定好的仓库目录中添加各版本接口
 *  - 添加新版本时。新版本库中只需要放置有改动的接口即可（删除也要添加一个类，做相应的处理）
 *  - 版本号中符号点"."，用下划线"_"代替。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiStore implements ApiStoreInterface
{
    /**
     * API仓库的根命名空间
     * 需要与变量$dir对应
     *
     * @var string
     */
    private $namespace;

    /**
     * API仓库的根mulu
     * 需要与变量$namespace对应
     *
     * @var string
     */
    private $dir;

    /**
     *
     * @param string $namespace
     * @param string $dir
     * @param string $format
     */
    public function __construct(string $namespace, string $dir)
    {
        $this->namespace    = $namespace;
        $this->dir          = $dir;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiStoreInterface::getNamespace()
     */
    public function getNamespace() : string
    {
        return $this->namespace;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiStoreInterface::getDir()
     */
    public function getDir() : string
    {
        return $this->dir;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiStoreInterface::findApiVersions()
     */
    public function findApiVersions(int $sort_type = 0) : array
    {
        return array_values(str_replace('_', '.', array_diff(scandir($this->getDir(), $sort_type), ['.', '..'])));
    }

    /**
     * 查找api接口对应执行的class
     *  - 首先在api仓库中查找有没有当前版本的api接口
     *  - 当传入的版本好不存在这个api接口时，查找上个版本库中有没有该接口
     *  - 编写新的api版本时，不需要将所有的接口都复制。仅需要把修改，或者新增加，或者删除的接口放在新的版本目录中
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiStoreInterface::findApiClass()
     */
    public function findApiClass(string $version, string $api_name) : string
    {
        $path           = str_replace('.', '/', $api_name);
        $version        = str_replace('.', '_', $version);
        $namespace      = rtrim( $this->getNamespace(), '\\' );
        $parse_paths    = explode('/', trim($path, '/'));
        
        $tmp_last_key               = key(array_slice($parse_paths, -1, 1, true));
        $parse_paths[$tmp_last_key] = implode('', array_map('ucfirst', explode('-', strtolower($parse_paths[$tmp_last_key]))));
        
        $path   = implode('\\', $parse_paths);
        $class  =  $namespace . '\\' . $version . '\\' . $path;
        if(!class_exists($class)){
            $versions   = str_replace('.', '_', $this->findApiVersions(1));
            foreach($versions AS $test_version){
                if(empty($version)){
                    $version    = $test_version;
                }
                $class  = $namespace . '\\' . $test_version . '\\' . $path;
                if(class_exists($class) && $test_version <= $version){
                    goto CLASS_MATCHED;
                }
            }
            throw new NotFoundApiException('API接口不存在。');
        }
        CLASS_MATCHED:
        return $class;
    }
}