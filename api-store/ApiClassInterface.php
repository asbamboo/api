<?php
namespace asbamboo\restfulApi\apiStore;

/**
 * api接口处理类接口。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiClassInterface
{
    /**
     * 执行api请求
     *
     * @param ApiRequestParamsInterface $Params
     */
    public function exec(ApiRequestParamsInterface $Params) : ApiResponseParamsInterface;
}