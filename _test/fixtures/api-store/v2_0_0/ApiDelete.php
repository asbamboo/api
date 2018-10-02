<?php
namespace asbamboo\api\_test\fixtures\apiStore\v2_0_0;

use asbamboo\api\apiStore\ApiClassAbstract;
use asbamboo\api\apiStore\ApiRequestParamsInterface;

/**
 * 测试删除1.0.0版本的接口用
 *
 * @delete
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiDelete extends ApiClassAbstract
{
    public function validate(ApiRequestParamsInterface $Params): bool
    {
        return true;
    }
}