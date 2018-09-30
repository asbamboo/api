<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\traits\CommonApiRequestParamsTrait;

/**
 * 请求参数管理
 *  - 这些参数应该在实例初始化化后只能读取，不能重写。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
 abstract class ApiRequestParamsAbstract implements ApiRequestParamsInterface
{
    /**
     * 构造方法为参数列表赋值为请求的参数值。
     *
     * @param ServerRequest $Request
     */
    public function __construct(ServerRequest $Request)
    {
        foreach($Request->getRequestParams() AS $param => $value){
            if(property_exists($this, $param)){
                $this->{$param} = $value;
            }
        }

        foreach($Request->getUploadedFiles() AS $param => $File){
            $this->{$param} = $File;
        }
    }

    /**
     * api request params 类可以不用添加与类的属性相关的get方法
     *  - 这个方法将认为所有类的属性都是可以通过get+属性名的方法获取属性的。
     *
     * @param string $method
     * @param array $arguments
     */
    public function __call($method, $arguments)
    {
        if(0 === strpos($method, 'get')){
            $property   = substr($method, 3);
            $property   = strtolower(ltrim(preg_replace('@([A-Z])@', '_$1', $property), '_'));
            if(property_exists($this, $property)){
                return $this->{$property};
            }
        }
    }
}