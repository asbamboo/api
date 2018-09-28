<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\document\ApiClassDoc;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\api\document\ApiRequestParamsDocInterface;
use asbamboo\api\document\ApiResponseParamsDocInterface;

class ApiClassDocTest extends TestCase
{
    public $ApiClassDoc;

    public function setUp()
    {
        $this->ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
    }

    public function testGetClassName()
    {
        $this->assertEquals(ApiFixed::class, $this->ApiClassDoc->getClassName());
    }

    public function testGetApiName()
    {
        $this->assertEquals('api-fixed', $this->ApiClassDoc->getApiName());
    }

    public function testGetPath()
    {
        $this->assertEquals('/api-fixed', $this->ApiClassDoc->getPath());
    }

    public function testGetLabelName()
    {
        $this->assertEquals('测试固定不变的接口', $this->ApiClassDoc->getLabelName());
    }

    public function testGetDesc()
    {
        $this->assertEquals('描述信息', $this->ApiClassDoc->getDesc());
    }

    public function testIsDelete()
    {
        $this->assertFalse($this->ApiClassDoc->isDelete());
    }

    public function testGetRequestParamsDoc()
    {
        $this->assertInstanceOf(ApiRequestParamsDocInterface::class, $this->ApiClassDoc->getRequestParamsDoc());
    }

    public function testGetResponseParamsDoc()
    {
        $this->assertInstanceOf(ApiResponseParamsDocInterface::class, $this->ApiClassDoc->getResponseParamsDoc());
    }
}
