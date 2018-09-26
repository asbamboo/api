<?php
namespace asbamboo\api\apiStore;

/**
 * api接口处理类接口。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiClassInterface
{
   /**
     *
     * @param ApiRequestParamsInterface $Params
     * @return ApiResponseParamsInterface|NULL
     */
    public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface;
}