<?php
namespace asbamboo\api\document;

use asbamboo\http\ResponseInterface;
use asbamboo\api\exception\NotFoundApiException;
use asbamboo\http\TextResponse;
use asbamboo\api\Constant;
use asbamboo\api\apiStore\ApiResponse;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\apiStore\ApiStoreInterface;
use asbamboo\api\apiStore\ApiClassInterface;
use asbamboo\api\apiStore\ApiRequestUrisInterface;
use asbamboo\api\view\TemplateInterface;
use asbamboo\api\view\Template;

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
     * 这份文档的名称
     *
     * @var string
     */
    private $name='';

    /**
     *
     * @var ApiStoreInterface
     */
    private $ApiStore;

    /**
     *
     * @var ApiRequestUrisInterface
     */
    private $ApiRequestUris;

    /**
     *
     * @var string
     */
    private $test_tool_uri;

    /**
     *
     * @var TemplateInterface
     */
    private $Template;

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
    public function __construct(ApiStoreInterface $ApiStore, TemplateInterface $Template = null)
    {
        $this->ApiStore     = $ApiStore;
        $this->Template     = $Template;
        if(is_null($this->Template)){
            $this->Template = new Template();
            $this->Template->setPath(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'view', 'template', 'document', 'default.html']));
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::setDocumentName()
     */
    public function setDocumentName(string $name) : DocumentInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::getDocumentName()
     */
    public function getDocumentName() : string
    {
        return $this->name;
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
     * @see \asbamboo\api\document\DocumentInterface::setTestToolUri()
     */
    public function setTestToolUri(string $uri) : DocumentInterface
    {
        $this->test_tool_uri    = $uri;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::getTestToolUri()
     */
    public function getTestToolUri() : ?string
    {
        return $this->test_tool_uri;
    }
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::setRequestUris()
     */
    public function setRequestUris(ApiRequestUrisInterface $ApiRequestUris) : DocumentInterface
    {
        $this->ApiRequestUris   = $ApiRequestUris;
        return $this;
    }

    /**
     * 如果api详情文档里面有请求uri说明的话，使用这个指定的api专用的uri集合
     * 如果api详情文档里面没有请求uri说明的话，使用公共的uri集合
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::getRequestUris()
     */
    public function getRequestUris() : ?ApiRequestUrisInterface
    {
        if($this->getApiName() && $this->getApiDetail()->getRequestUris()){
            return $this->getApiDetail()->getRequestUris();
        }
        return $this->ApiRequestUris;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\DocumentInterface::response()
     */
    public function response() : ResponseInterface
    {
        return new TextResponse($this->Template->render([
            'all_versions'          => $this->ApiStore->findApiVersions(1),
            'cur_version'           => $this->getVersion(),
            'lists'                 => $this->getApiLists(),
            'detail'                => $this->getApiName() ? $this->getApiDetail() : null,
            'request_example'       => $this->getRequestExample(),
            'response_example'      => $this->getResponseExample(),
            'uris'                  => $this->getRequestUris(),
            'test_tool_uri'         => $this->getTestToolUri(),
            'document_name'         => $this->getDocumentName(),
        ]));
    }

    /**
     * 返回api 版本信息组成的数组
     *
     * @return array
     */
    public function getApiVersions() : array
    {
        return $this->ApiStore->findApiVersions(1);
    }

    /**
     * 返回api接口组成的数组
     *
     * @return array
     */
    public function getApiLists() : array
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
        if(!isset($api_lists[$this->getApiName()])){
            throw new NotFoundApiException(sprintf('api 接口不存在，版本[%s], api 名称[%s]', $this->getVersion(), $this->getApiName()));
        }
        return $api_lists[$this->getApiName()];
    }

    /**
     * 返回请求值示例
     *
     * @return string
     */
    private function getRequestExample() : string
    {
        /**
         * @var ApiRequestParamDoc $RequestParamDoc
         */
        $example    = '';
        if($this->getApiName()){
            $url                = 'http://XXXXXXXX';
            if($this->getRequestUris()){
                foreach($this->getRequestUris() AS $ApiRequestUri){
                    if($ApiRequestUri->getUri()){
                        $url    = $ApiRequestUri->getUri();
                        break;
                    }
                }
            }
            $example            = [];
            $example[]          = 'curl ' . $url . ' \\';
            $Detail             = $this->getApiDetail();
            $RequestParamsDoc   = $Detail->getRequestParamsDoc();
            foreach($RequestParamsDoc AS $RequestParamDoc){
                $name       = $RequestParamDoc->getName();
                $value      = $RequestParamDoc->getExampleValue();
                $value      = $name == 'api_name' ? $this->getApiName() : $value;
                $value      = $name == 'version' ? $this->getVersion() : $value;
                $example[]  = '-d ' . $name . '=' . urlencode($value) . ' \\';
            }
            $example            = implode("\r\n", $example);
        }
        return $example;
    }

    /**
     * 返回响应值示例
     *
     * @return string
     */
    public function getResponseExample() : string
    {
        /**
         * @var ApiResponseParamDoc $ResponseParamDoc
         */
        $example    = '';
        if($this->getApiName()){
            $data               = [];
            $ResponseParams     = null;
            $Detail             = $this->getApiDetail();
            $ResponseParamsDoc  = $Detail->getResponseParamsDoc();
            if($ResponseParamsDoc){
                foreach($ResponseParamsDoc AS $ResponseParamDoc){
                    $data[$ResponseParamDoc->getName()] = $ResponseParamDoc->getExampleValue();
                }
                $ResponseParams = new class($data) extends ApiResponseParams{
                    public function __construct($data){
                        $this->data = $data;
                    }
                    public function getObjectVars(): ? array
                    {
                        return $this->data;
                    }
                };
            }
            $ApiResponse   = new ApiResponse();
            $ApiResponse->setCode(Constant::RESPONSE_STATUS_OK);
            $ApiResponse->setMessage(Constant::RESPONSE_MESSAGE_OK);
            $Response   = $ApiResponse->makeResponse($ResponseParams);
            $example    = $Response->getBody()->getContents();
        }
        return $example;
    }
}