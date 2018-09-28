<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed;

use asbamboo\api\apiStore\ApiResponseParams;

class ResponseParams extends ApiResponseParams
{
    /**
     * @range 0~255
     * @desc 测试ID
     * @var string
     */
    protected $id   = 'test_id';
}