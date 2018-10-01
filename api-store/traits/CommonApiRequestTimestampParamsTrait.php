<?php
namespace asbamboo\api\apiStore\traits;
/**
 * api用于验证请求参数是否已经过期的公共请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
trait CommonApiRequestTimestampParamsTrait
{
    /**
     * 时间戳参数是为了使得过去的请求参数失效
     *
     * @desc 时间戳 格式为:yyyy-mm-dd HH:mm:ss,如(2018-09-27 20:01:53)
     * @example 2018-09-27 20:01:53
     * @required 必须
     * @common
     * @range 10分钟内有效时间戳
     * @var string
     */
    protected $timestamp;

    /**
     * 时间戳 格式为:yyyy-mm-dd HH:mm:ss,如(2018-09-27 20:01:53)
     *
     * @return string
     */
    public function getTimestamp() : string
    {
        return $this->timestamp;
    }
}
