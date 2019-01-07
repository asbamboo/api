<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed;

use asbamboo\api\apiStore\ApiResponseParams;

class ResponseParams extends ApiResponseParams
{
    /**
     * @range 0~255
     * @desc 测试ID
     * @example 10089
     * @var string
     */
    protected $id;
}