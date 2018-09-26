<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed;

use asbamboo\api\apiStore\ApiRequestParamsInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
class RequestParams implements ApiRequestParamsInterface
{
    public function validate(): bool
    {
        return true;
    }
}

