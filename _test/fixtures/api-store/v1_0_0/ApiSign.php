<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0;

use asbamboo\api\apiStore\ApiClassAbstract;
use asbamboo\api\apiStore\ApiResponseParamsInterface;
use asbamboo\api\apiStore\ApiRequestParamsInterface;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\ResponseParams;

/**
 * @name 测试具有签名的接口
 * @desc 描述信息
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年1月7日
 */
class ApiSign extends ApiClassAbstract
{
    protected function successApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
    {
        return new ResponseParams(['id' => 'test_id']);
    }

    public function validate(ApiRequestParamsInterface $Params): bool
    {
        return true;
    }
}