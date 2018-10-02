<?php
namespace asbamboo\api\_test\fixtures\apiStore\v2_0_0;

use asbamboo\api\apiStore\ApiClassAbstract;
use asbamboo\api\apiStore\ApiRequestParamsInterface;

/**
 * 测试更新1.0.0的版本接口用
 *
 * @uris type=dev,uri=http://test.delete,desc=desc
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiUpdate extends ApiClassAbstract
{
    public function validate(ApiRequestParamsInterface $Params): bool
    {
        return true;
    }
}