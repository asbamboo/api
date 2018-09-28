<?php
namespace asbamboo\api\apiStore;

/**
 * 使用签名验证的请求参数管理
 *  - 这些参数应该在实例初始化化后只能读取，不能重写。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiRequestSignParamsInterface extends ApiRequestParamsInterface
{
    /**
     * 一个请求api接口的应用程序的唯一标识符号
     *
     * @return string
     */
    public function getAppKey() : string;

    /**
     * 时间戳参数是为了使得过去的请求参数失效
     *  - 格式为:yyyy-mm-dd HH:mm:ss,如(2018-09-27 20:01:53)
     *
     * @return string
     */
    public function getTimestamp() : string;

    /**
     * 签名字符串
     *
     * @return string
     */
    public function getSign() : string;
}