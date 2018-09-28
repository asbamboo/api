<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\ResponseParams;
use asbamboo\api\document\ApiResponseParamsDoc;

class ApiResponseParamsDocTest extends TestCase
{
    public $ApiResponseParamsDoc;

    public function setUp()
    {
        $api_response_params_class   = ResponseParams::class;
        $this->ApiResponseParamsDoc  = new ApiResponseParamsDoc($api_response_params_class);
    }

    public function testMain()
    {
        $api_response_params = [];
        foreach($this->ApiResponseParamsDoc AS $ApiResponseParamDoc){
            $api_response_params[]   = $ApiResponseParamDoc->getName();
        }
        $this->assertCount(1, $api_response_params);
    }
}