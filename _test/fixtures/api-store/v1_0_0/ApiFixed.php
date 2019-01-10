<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0;

use asbamboo\api\apiStore\ApiClassAbstract;
use asbamboo\api\apiStore\ApiResponseParamsInterface;
use asbamboo\api\apiStore\ApiRequestParamsInterface;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\ResponseParams;

/**
 * 测试在2.0.0版本中沿用1.0.0的版本
 *
 * @name 测试固定不变的接口[url]http://link[/url][url:http://link]link test[/url]
 * @desc 描述信息
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiFixed extends ApiClassAbstract
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