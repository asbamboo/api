<?php
namespace asbamboo\api\_test\apiStore;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiRequestUri;
use asbamboo\api\apiStore\ApiRequestUris;
use asbamboo\api\apiStore\ApiRequestUrisInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
class ApiRequestUrisTest extends TestCase
{
    public function testAdd()
    {
        $ApiRequestUri      = new ApiRequestUri();
        $ApiRequestUris     = new ApiRequestUris($ApiRequestUri);
        $ApiRequestUri      = new ApiRequestUri('test', 'desc', 'develop');
        $this->assertInstanceOf(ApiRequestUrisInterface::class, $ApiRequestUris->add($ApiRequestUri));
        return [$ApiRequestUris, $ApiRequestUri];
    }

    /**
     * @depends testAdd
     */
    public function testGet($data)
    {
        list($ApiRequestUris, $ApiRequestUri)   = $data;
        $this->assertEquals($ApiRequestUri, $ApiRequestUris->get());
        $this->assertEquals('', $ApiRequestUris->get('prod'));
    }
}