<?php
namespace asbamboo\api\document;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiStoreInterface;
use asbamboo\api\apiStore\ApiClassInterface;
use asbamboo\api\exception\NotFoundApiException;
use asbamboo\http\TextResponse;

/**
 * 文档生成器
 *  - 根据获取的api仓库中api类的注释信息解析生成文档。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
class Document implements DocumentInterface
{
    /**
     *
     * @var ApiStoreInterface
     */
    private $ApiStore;

    /**
     *
     * @var string
     */
    private $template;

    /**
     *
     * @var string
     */
    private $api_name = '';

    /**
     *
     * @var string
     */
    private $version = '';

    /**
     * 当前$version下 所有api列表
     *  - 数组的key是 api name
     *  - 数组的value是 api class doc
     *
     * @var array
     */
    private $api_lists;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param string $template
     */
    public function __construct(ApiStoreInterface $ApiStore, string $template = null)
    {
        $this->ApiStore     = $ApiStore;
        $this->template     = $template ?? __DIR__ . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'default.html';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::setVersion()
     */
    public function setVersion(string $version) : DocumentInterface
    {
        $this->api_lists    = null;
        $this->version      = $version;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::getVersion()
     */
    public function getVersion() : string
    {
        if(empty($this->version)){
            $this->version  = current($this->ApiStore->findApiVersions(1));
        }
        return $this->version;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::setApiName()
     */
    public function setApiName(string $api_name) : DocumentInterface
    {
        $this->api_name = $api_name;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::getApiName()
     */
    public function getApiName() : string
    {
        return $this->api_name;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::response()
     */
    public function response() : ResponseInterface
    {
        $all_versions   = $this->ApiStore->findApiVersions(1);
        $lists          = $this->getApiLists();
        $detail         = $this->getApiDetail();
        ob_start();
        include $this->layout;
        $html   = ob_get_contents();
        ob_end_clean();
        return new TextResponse($html);
    }

    /**
     * 返回api 版本信息组成的数组
     *
     * @return array
     */
    private function getApiVersions() : array
    {
        return $this->ApiStore->findApiVersions(1);
    }

    /**
     * 返回api接口组成的数组
     *
     * @return array
     */
    private function getApiLists() : array
    {
        if(empty($this->api_lists)){
            $this->api_lists    = [];
            $dir                = $this->ApiStore->getDir();
            $api_versions       = $this->ApiStore->findApiVersions();
            foreach($api_versions AS $api_version){
                if($api_version <= $this->getVersion()){
                    $version_dir        = rtrim($dir, DIRECTORY_SEPARATOR). DIRECTORY_SEPARATOR . str_replace('.', '_', $api_version);
                    $this->api_lists    = array_merge($this->readApiListInfo($version_dir), $this->api_lists);
                }
            }
            ksort($this->api_lists);
        }
        return $this->api_lists;
    }


    /**
     * 读取Api列表的帮助信息
     *
     * @param string $version_dir
     * @return array
     */
    private function readApiListInfo(string $version_dir) : array
    {
        $api_lists      = [];
        $names          = array_diff(scandir($version_dir), ['.', '..']);

        foreach($names AS $name){
            $path   = rtrim($version_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
            if(is_dir( $path )){
                $api_lists  = array_merge($api_lists, $this->readApiListInfo($path));
                continue;
            }
            $class  = '';
            if(is_file($path)){
                $storedir_length    = strlen($this->ApiStore->getDir());
                $ext_pos            = '-4'; //截掉文件后缀名".php"
                $class              = substr($path, $storedir_length, $ext_pos);
                $class              = str_replace(DIRECTORY_SEPARATOR, '\\', $class);
                $class              = rtrim($this->ApiStore->getNamespace(), '\\') . $class;
            }

            if(class_exists($class) && in_array(ApiClassInterface::class, class_implements($class))){
                $ApiClassDoc                            = new ApiClassDoc($class, $this->ApiStore->getNamespace());
                $api_lists[$ApiClassDoc->getApiName()]  = $ApiClassDoc;
            }
        }
        return $api_lists;
    }

    /**
     * 获取一个api接口文档详情信息
     *
     * @throws NotFoundApiException
     * @return ApiClassDocInterface
     */
    public function getApiDetail() : ApiClassDocInterface
    {
        $api_lists  = $this->getApiLists();
        if(isset($api_lists[$this->getApiName()])){
            throw new NotFoundApiException(sprintf('api 接口不存在，版本[%s], api 名称[%s]', $this->getVersion(), $this->getApiName()));
        }
        return $api_lists[$this->getApiName()];
    }
}