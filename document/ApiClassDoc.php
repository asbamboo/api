<?php
namespace asbamboo\api\document;

use asbamboo\api\apiStore\ApiRequestUris;
use asbamboo\api\apiStore\ApiRequestUrisInterface;
use asbamboo\api\apiStore\ApiRequestUri;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
class ApiClassDoc implements ApiClassDocInterface
{
    /**
     *
     * @var string
     */
    private $api_class;

    /**
     * 注释信息组成的数组
     *
     * @var array
     */
    private $docs;

    /**
     * 以path风格请求接口时，访问接口使用的path
     *
     * @var string
     */
    private $path;

    /**
     * 以api name风格请求接口时，访问接口使用的api name
     *
     * @var string
     */
    private $api_name;

    /**
     *
     * @var ApiRequestParamsDocInterface
     */
    private $ApiRequestParamsDoc;

    /**
     *
     * @var ApiResponseParamsDocInterface
     */
    private $ApiResponseParamsDoc;

    /**
     *
     * @var ApiRequestUrisInterface
     */
    private $ApiRequestUris;

    /**
     *
     * @param string $api_class
     * @param string $api_store_namespace
     */
    public function __construct(string $api_class, string $api_store_namespace)
    {
        $this->api_class    = $api_class;
        $this->parseDoc($api_class);
        $this->parsePath($api_class, $api_store_namespace);
    }

    /**
     * 解析注释行
     *
     * @param string $api_class ApiClassInterface的一个类
     */
    private function parseDoc(string $api_class) : void
    {
        $Reflection = new \ReflectionClass($api_class);
        $document   = $Reflection->getDocComment();

        if(preg_match_all('#@(\w+)(\s(.*))?[\r\n]#siU', $document, $matches)){
            foreach($matches[1] AS $index => $key){
                $value                = trim($matches[3][$index]);
                if(preg_match('@^eval:(.*)$@siU', $value, $match)){
                    $value    = eval('return ' . $match[1] . ';');
                }
                $value  = preg_replace([
                    '#\[\s*url\s*\]([^\[]*)\[\s*/url\s*\]#siU',
                    '#\[\s*url\s*:\s*([^\]]*)\s*\]([^\[]*)\[\s*/url\s*\]#siU',
                ], [
                    '<a href="$1">$1</a>',
                    '<a href="$1">$2</a>',
                ], $value);
                $this->docs[$key][]   = $value;
            }
        }
    }

    /**
     * 解析以path风格请求接口时，访问接口使用的path
     *
     * @param string $api_class api类名
     * @param string $api_store_namespace API 存放的命名空间
     */
    private function parsePath(string $api_class, string $api_store_namespace)
    {
        $api_store_namespace    = rtrim($api_store_namespace, '\\');
        $parsing                = preg_replace(addslashes("@{$api_store_namespace}\\([^\\]+)\\@siU"), '\\', $api_class);
        $parsing                = explode('\\', $parsing);
        $parsing                = array_map(function($p){
            return strtolower(trim(preg_replace('@([A-Z])@', '-$1', $p), '-'));
        },$parsing);

            $this->path = implode('/', $parsing);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getClassName()
     */
    public function getClassName() : string
    {
        return $this->api_class;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getApiName()
     */
    public function getApiName() : string
    {
        if(empty($this->api_name)){
            $this->api_name = str_replace('/', '.', trim($this->getPath(), '/'));
        }
        return $this->api_name;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getPath()
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getLabelName()
     */
    public function getLabelName() : string
    {
        return isset($this->docs['name']) ? implode("\r\n", $this->docs['name']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getDesc()
     */
    public function getDesc() : string
    {
        return isset($this->docs['desc']) ? implode("\r\n", $this->docs['desc']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::isDelete()
     */
    public function isDelete() : bool
    {
        return !empty( $this->docs['delete'] );
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getRequestUris()
     */
    public function getRequestUris() : ?ApiRequestUrisInterface
    {
        if(!$this->ApiRequestUris && !empty($this->docs['uris'])){
            $this->ApiRequestUris = new ApiRequestUris();
            foreach($this->docs['uris'] AS $uri){
                $uri_data   = [];
                $parse      = explode(',', $uri);
                foreach($parse AS $p){
                    @list($key, $value) = explode('=', $p);
                    $uri_data[$key] = $value;
                }
                $this->ApiRequestUris->add(new ApiRequestUri($uri_data['uri'] ?? '', $uri_data['desc'] ?? '', $uri_data['type'] ?? ''));
            }
        }
        return $this->ApiRequestUris;
    }


    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getRequestParamsDoc()
     */
    public function getRequestParamsDoc() : ?ApiRequestParamsDocInterface
    {
        if(!$this->ApiRequestParamsDoc){
            $api_request_params_class   = empty($this->docs['request']) ? null : current($this->docs['request']);
            if(empty( $api_request_params_class )){
                $api_request_params_class   = $this->getClassName() . '\\' . 'RequestParams';
            }
            if(class_exists( $api_request_params_class )){
                $this->ApiRequestParamsDoc  = new ApiRequestParamsDoc($api_request_params_class);
            }
        }
        return $this->ApiRequestParamsDoc;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getResponseParamsDoc()
     */
    public function getResponseParamsDoc() : ?ApiResponseParamsDocInterface
    {
        if(!$this->ApiResponseParamsDoc){
            $api_response_params_class   = empty($this->docs['response']) ? null : current($this->docs['response']);
            if(empty( $api_response_params_class )){
                $api_response_params_class   = $this->getClassName() . '\\' . 'ResponseParams';
            }
            if(class_exists( $api_response_params_class )){
                $this->ApiResponseParamsDoc  = new ApiResponseParamsDoc($api_response_params_class);
            }
        }
        return $this->ApiResponseParamsDoc;
    }
}