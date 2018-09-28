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
     * 执行api请求
     *  - 参数 ApiRequestParamsInterface 应该是 ApiClassInterface::getApiRequestParamsClass() 生成的实例
     *  - 返回值 ApiResponseParamsInterface 用于生成响应信息（ApiResponseInterface）
     *
     * @param ApiRequestParamsInterface $Params
     * @return ApiResponseParamsInterface|NULL
     */
    public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface;
}