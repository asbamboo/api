<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\RequestParams;
use asbamboo\api\document\ApiRequestParamDoc;

class ApiRequestParamDocTest extends TestCase
{
    public function testGetName()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('version', $ApiRequestParamDoc->getName());
    }

    public function testGetDefaultValue()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('v1.0.0', $ApiRequestParamDoc->getDefaultValue());
    }

    public function testGetExampleValue()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('v1.0.0', $ApiRequestParamDoc->getExampleValue());

        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'api_name');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('Api版本', $ApiRequestParamDoc->getExampleValue());
    }

    public function testGetVar()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('文本', $ApiRequestParamDoc->getVar());
    }

    public function testGetRequired()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('非必须', $ApiRequestParamDoc->getRequired());
    }

    public function testGetRange()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('v1.0.0-v2.0.0', $ApiRequestParamDoc->getRange());

        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'api_name');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('api版本', $ApiRequestParamDoc->getRange());
    }

    public function testGetDesc()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('api版本', $ApiRequestParamDoc->getDesc());

        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'api_name');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertEquals('api版本', $ApiRequestParamDoc->getDesc());
    }

    public function isCommon()
    {
        $ReflectionProperty   = new \ReflectionProperty(RequestParams::class, 'version');
        $ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
        $this->assertTrue($ApiRequestParamDoc->isCommon());
    }
}