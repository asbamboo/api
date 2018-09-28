<?php
namespace asbamboo\api\_test\fixtures\apiStore\v2_0_0\api;

use asbamboo\api\apiStore\ApiClassAbstract;
use asbamboo\api\apiStore\ApiRequestParamsInterface;

class Inner extends ApiClassAbstract
{
    public function validate(ApiRequestParamsInterface $Params): bool
    {
        return true;
    }
}
