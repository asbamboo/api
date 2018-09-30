<?php
namespace asbamboo\api\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiStore;
use asbamboo\api\document\Document;
use asbamboo\http\TextResponse;
use asbamboo\api\document\DocumentInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class DocumentTest extends TestCase
{
    public $ApiStore;

    public function setUp()
    {
        $namespace      = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir            = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $this->ApiStore = new ApiStore($namespace, $dir);
    }

    public function testSetVersion()
    {
        $Document       = new Document($this->ApiStore);
        $Document       = $Document->setVersion('version');
        $this->assertInstanceOf(DocumentInterface::class, $Document);
        return $Document;
    }

    /**
     * @depends testSetVersion
     */
    public function testGetVersion(Document $Document)
    {
        $this->assertEquals('version', $Document->getVersion());
    }

    public function testSetApiName()
    {
        $Document       = new Document($this->ApiStore);
        $Document       = $Document->setApiName('api_name');
        $this->assertInstanceOf(DocumentInterface::class, $Document);
        return $Document;
    }

    /**
     * @depends testSetApiName
     */
    public function testGetApiName(Document $Document)
    {
        $this->assertEquals('api_name', $Document->getApiName());
    }

    public function testResponse()
    {
        $Document       = new Document($this->ApiStore);
        $Document->setApiName('api-fixed');
//         var_dump($Document->response()->getBody()->getContents());exit;
        $this->assertInstanceOf(TextResponse::class, $Document->response());
    }
}