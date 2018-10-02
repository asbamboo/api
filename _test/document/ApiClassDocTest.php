<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\document\ApiClassDoc;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\api\document\ApiRequestParamsDocInterface;
use asbamboo\api\document\ApiResponseParamsDocInterface;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiUpdate;
use asbamboo\api\_test\fixtures\apiStore\v2_0_0\ApiDelete;

class ApiClassDocTest extends TestCase
{
    public function testGetClassName()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals(ApiFixed::class, $ApiClassDoc->getClassName());
    }

    public function testGetApiName()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('api-fixed', $ApiClassDoc->getApiName());
    }

    public function testGetPath()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('/api-fixed', $ApiClassDoc->getPath());
    }

    public function testGetLabelName()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('测试固定不变的接口', $ApiClassDoc->getLabelName());
        $ApiClassDoc = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('', $ApiClassDoc->getLabelName());
    }

    public function testGetDesc()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('描述信息', $ApiClassDoc->getDesc());
        $ApiClassDoc = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('', $ApiClassDoc->getDesc());
    }

    public function testIsDelete()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertFalse($ApiClassDoc->isDelete());
        $ApiClassDoc = new ApiClassDoc(ApiDelete::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertTrue($ApiClassDoc->isDelete());
    }

    public function testGetRequestUris()
    {
        $ApiClassDoc = new ApiClassDoc(ApiDelete::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals(null, $ApiClassDoc->getRequestUris());

        $ApiClassDoc = new ApiClassDoc(ApiUpdate::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertEquals('dev', $ApiClassDoc->getRequestUris()->get('dev')->getType());
        $this->assertEquals('http://test.delete', $ApiClassDoc->getRequestUris()->get('dev')->getUri());
        $this->assertEquals('desc', $ApiClassDoc->getRequestUris()->get('dev')->getDesc());
    }

    public function testGetRequestParamsDoc()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertInstanceOf(ApiRequestParamsDocInterface::class, $ApiClassDoc->getRequestParamsDoc());
    }

    public function testGetResponseParamsDoc()
    {
        $ApiClassDoc = new ApiClassDoc(ApiFixed::class, 'asbamboo\\api\\_test\\fixtures\\apiStore\\');
        $this->assertInstanceOf(ApiResponseParamsDocInterface::class, $ApiClassDoc->getResponseParamsDoc());
    }
}
