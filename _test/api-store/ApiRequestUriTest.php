<?php
namespace asbamboo\api\_test\apiStore;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiRequestUri;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
class ApiRequestUriTest extends TestCase
{
    public function testGetUri()
    {
        $ApiRequestUri  = new ApiRequestUri();
        $this->assertEquals('', $ApiRequestUri->getUri());
        $ApiRequestUri  = new ApiRequestUri('http://test');
        $this->assertEquals('http://test', $ApiRequestUri->getUri());
    }


    public function testGetDesc()
    {
        $ApiRequestUri  = new ApiRequestUri();
        $this->assertEquals('', $ApiRequestUri->getDesc());
        $ApiRequestUri  = new ApiRequestUri('http://test', 'desc');
        $this->assertEquals('desc', $ApiRequestUri->getDesc());
    }

    public function testGetType()
    {
        $ApiRequestUri  = new ApiRequestUri();
        $this->assertEquals('', $ApiRequestUri->getType());
        $ApiRequestUri  = new ApiRequestUri('http://test', 'desc', 'dev');
        $this->assertEquals('dev', $ApiRequestUri->getType());
    }
}