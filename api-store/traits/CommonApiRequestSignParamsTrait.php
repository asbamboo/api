<?php
namespace asbamboo\api\apiStore\traits;
/**
 * api用于签名验证的公共请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
trait CommonApiRequestSignParamsTrait
{
    /**
     * app_key是一个请求api接口的应用程序的唯一标识符号
     *
     * @desc app key
     * @required 必须
     * @common
     * @var string
     * @range 每个应用唯一
     */
    protected $app_key = '';

    /**
     * api接口处理程序会按规则在服务端生成sign，然后与请求参数sign做比较
     *  - 未安装规则生成sign被认为可能是恶意请求
     *
     * @desc 签名字符串
     * @required 必须
     * @common
     * @var string
     * @range 请查看签名规则
     */
    protected $sign = '';

    /**
     * app_key是一个请求api接口的应用程序的唯一标识符号
     *
     * @return string
     */
    public function getAppKey() : string
    {
        return $this->app_key;
    }

    /**
     * api接口处理程序会按规则在服务端生成sign，然后与请求参数sign做比较
     *
     * @return string
     */
    public function getSign() : string
    {
        return $this->sign;
    }
}
