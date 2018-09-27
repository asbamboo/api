<?php
namespace asbamboo\api\document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
class ApiClassDoc implements ApiClassDocInterface
{
    /**
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
     * @param string $api_class
     * @param string $api_store_namespace
     */
    public function __construct(string $api_class, string $api_store_namespace)
    {
        $this->parseDoc($api_class);
        $this->parsePath($api_class, $api_store_namespace);
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
        return isset($this->docs['name']) ? implode('\r\n', $this->docs['name']) : '';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiClassDocInterface::getDesc()
     */
    public function getDesc() : string
    {
        return isset($this->docs['desc']) ? implode('\r\n', $this->docs['desc']) : '';
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
                $this->docs[$key][]   = trim($matches[3][$index]);
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
}