<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\RequestParams;
use asbamboo\api\document\ApiRequestParamDoc;
use asbamboo\api\document\ApiRequestParamDocInterface;

class ApiRequestParamDocTest extends TestCase
{
    /**
     *
     * @var ApiRequestParamDocInterface
     */
    public $ApiRequestParamDoc;

    public function setUp()
    {
        $ReflectionProperty         = new \ReflectionProperty(RequestParams::class, 'version');
        $this->ApiRequestParamDoc   = new ApiRequestParamDoc($ReflectionProperty);
    }

    public function testGetName()
    {
        $this->assertEquals('version', $this->ApiRequestParamDoc->getName());
    }

    public function testGetDefaultValue()
    {
        $this->assertEquals('v1.0.0', $this->ApiRequestParamDoc->getDefaultValue());
    }

    public function testGetVar()
    {
        $this->assertEquals('文本', $this->ApiRequestParamDoc->getVar());
    }

    public function testGetRequired()
    {
        $this->assertEquals('非必须', $this->ApiRequestParamDoc->getRequired());
    }

    public function testGetRange()
    {
        $this->assertEquals('v1.0.0-v2.0.0', $this->ApiRequestParamDoc->getRange());
    }

    public function testGetDesc()
    {
        $this->assertEquals('api版本', $this->ApiRequestParamDoc->getDesc());
    }

    public function isCommon()
    {
        $this->assertTrue($this->ApiRequestParamDoc->isCommon());
    }
}