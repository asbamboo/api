<?php
namespace asbamboo\api\document;

use asbamboo\api\apiStore\ApiRequestUrisInterface;

/**
 * 实现"asbamboo\restfulApi\apiStore\ApiClassInterface"的类的帮助信息。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
interface ApiClassDocInterface
{
    /**
     * 执行api请求的类的类名
     *
     * @return string
     */
    public function getClassName() : string;

    /**
     * api 访问的 api名称
     *  - api请求时需要传递的api名称
     *  - 在asbamboo\api模块内，使用内置的controller访问api接口时, 变量$api_name可以是api name
     *  - api name 只是将 path 的目录分隔符 "/" 替换成点"."
     *
     * @return string
     */
    public function getApiName() : string;

    /**
     * api 访问 path
     *  - 在asbamboo\api模块内，使用内置的controller访问api接口时, 变量$api_name可以是path
     *  - api name 只是将 path 的目录分隔符 "/" 替换成点"."
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * API标签名称，在html中显示的文字名称
     * 应该解析ApiClass的注释中的 "@name" 信息
     *
     * @return string
     */
    public function getLabelName() : string;

    /**
     * API说明
     * 应该解析ApiClass的注释中的 "@desc" 信息
     *
     * @return string
     */
    public function getDesc() : string;

    /**
     * 如果注释里面解析到 "@delete", 表示接口在这个版本删除。
     *
     * @return bool
     */
    public function isDelete() : bool;

    /**
     * 返回请求的uris集合
     * 应该解析ApiClass的注释中的 "@uris" 信息
     * “@uris” 格式应该是 type=test,uri=http://test,desc=desc
     *
     * @return ApiRequestUrisInterface|NULL
     */
    public function getRequestUris() : ?ApiRequestUrisInterface;

    /**
     * 返回 api 请求参数说明
     *  - 解析ApiClass的注释中的 "@request" 信息
     *  - 如果 "@request" 信息不存在，默认使用 "api class name // request params" 类
     *  - 如果默认的request params类也不存在，那么请求参数为空
     *
     * @return ApiRequestParamsDocInterface|NULL
     */
    public function getRequestParamsDoc() : ?ApiRequestParamsDocInterface;

    /**
     * 返回 api 响应参数说明
     *  - 解析ApiClass的注释中的 "@response" 信息
     *  - 如果 "@response" 信息不存在，默认使用 "api class name // response params" 类
     *  - 如果默认的response params类也不存在，那么响应参数为空
     *
     * @return ApiResponseParamsDocInterface|NULL
     */
    public function getResponseParamsDoc() : ?ApiResponseParamsDocInterface;
}