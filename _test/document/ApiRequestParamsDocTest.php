<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\document\ApiRequestParamsDoc;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\RequestParams;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class ApiRequestParamsDocTest extends TestCase
{
    public $ApiRequestParamsDoc;

    public function setUp()
    {
        $api_request_params_class   = RequestParams::class;
        $this->ApiRequestParamsDoc  = new ApiRequestParamsDoc($api_request_params_class);
    }

    public function testMain()
    {
        $api_request_params = [];
        foreach($this->ApiRequestParamsDoc AS $ApiRequestParamDoc){
            $api_request_params[]   = $ApiRequestParamDoc->getName();
        }
        $this->assertCount(3, $api_request_params);
    }

    public function testGetClass()
    {
        $this->assertEquals(RequestParams::class, $this->ApiRequestParamsDoc->getClass());
    }
}