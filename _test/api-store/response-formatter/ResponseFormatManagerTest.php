<?php
namespace asbamboo\api\_test\apiStore\responseFormatter;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\responseFormatter\JsonResponseFormatter;
use asbamboo\api\apiStore\responseFormatter\ResponseFormatManager;
use asbamboo\api\exception\NotSupportedFormatException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
class ResponseFormatManagerTest extends TestCase
{
    public function testAppendHandler()
    {
        $ResponseFormatManager  = new ResponseFormatManager();
        $ResponseFormatManager->appendHandler('json', JsonResponseFormatter::class);
        $this->assertTrue($ResponseFormatManager->hasHandler('json'));
    }

    public function testRemoveHandler()
    {
        $ResponseFormatManager  = new ResponseFormatManager();
        $ResponseFormatManager->appendHandler('json', JsonResponseFormatter::class);
        $ResponseFormatManager->removeHandler('json');
        $this->assertFalse($ResponseFormatManager->hasHandler('json'));
    }

    public function testGetHandlerException()
    {
        $this->expectException(NotSupportedFormatException::class);
        $ResponseFormatManager  = new ResponseFormatManager();
        $ResponseFormatManager->getHandler('json');
    }

    public function testGetHandler()
    {
        $ResponseFormatManager  = new ResponseFormatManager();
        $ResponseFormatManager->appendHandler('json', JsonResponseFormatter::class);
        $JsonResponseFormatter  = $ResponseFormatManager->getHandler('json');
        $this->assertInstanceOf(JsonResponseFormatter::class, $JsonResponseFormatter);
    }
}
