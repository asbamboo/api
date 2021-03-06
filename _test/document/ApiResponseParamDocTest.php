<?php
namespace asbamboo\api\_test\apiStore\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\ResponseParams;
use asbamboo\api\document\ApiResponseParamDoc;

class ApiResponseParamDocTest extends TestCase
{
    public $ApiResponseParamDoc;

    public function setUp()
    {
        $ReflectionProperty         = new \ReflectionProperty(ResponseParams::class, 'id');
        $this->ApiResponseParamDoc  = new ApiResponseParamDoc($ReflectionProperty);
    }

    public function testGetName()
    {
        $this->assertEquals('id', $this->ApiResponseParamDoc->getName());
    }

    public function testGetExampleValue()
    {
        $this->assertEquals('10089', $this->ApiResponseParamDoc->getExampleValue());
    }

    public function testGetVar()
    {
        $this->assertEquals('string', $this->ApiResponseParamDoc->getVar());
    }

    public function testGetRange()
    {
        $this->assertEquals('0~255', $this->ApiResponseParamDoc->getRange());
    }

    public function testGetDesc()
    {
        $this->assertContains('测试ID', $this->ApiResponseParamDoc->getDesc());
        $this->assertContains('<a href="link">link</a>', $this->ApiResponseParamDoc->getDesc());
        $this->assertContains('<a href="link">test</a>', $this->ApiResponseParamDoc->getDesc());
    }
}