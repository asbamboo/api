<?php
namespace asbamboo\api\_test\document;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiStore;
use asbamboo\api\document\Document;
use asbamboo\http\TextResponse;
use asbamboo\api\document\DocumentInterface;
use asbamboo\api\apiStore\ApiRequestUris;
use asbamboo\api\apiStore\ApiResponseSigned;

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

    public function testSetDocumentName()
    {
        $Document       = new Document($this->ApiStore);
        $this->assertInstanceOf(DocumentInterface::class, $Document->setDocumentName('document'));
        return $Document;
    }

    /**
     * @depends testSetDocumentName
     * @param DocumentInterface $Document
     * @return string
     */
    public function testGetDocumentName(DocumentInterface $Document)
    {
        $this->assertEquals('document', $Document->getDocumentName());
        $Document       = new Document($this->ApiStore);
        $this->assertEquals('', $Document->getDocumentName());
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
        return $Document;
    }

    /**
     * @depends testGetApiName
     */
    public function testSetTestToolUri(Document $Document)
    {
        $this->assertInstanceOf(DocumentInterface::class, $Document->setTestToolUri('http://test.tool'));
        return $Document;
    }

    /**
     * @depends testSetTestToolUri
     */
    public function testGetTestToolUri(Document $Document)
    {
        $this->assertEquals('http://test.tool', $Document->getTestToolUri());
        $Document       = new Document($this->ApiStore);
        $this->assertNull($Document->getTestToolUri());
    }

    public function testSetRequestUris()
    {
        $Document       = new Document($this->ApiStore);
        $ApiRequestUris = new ApiRequestUris();
        $Document       = $Document->setRequestUris($ApiRequestUris);
        $this->assertInstanceOf(DocumentInterface::class, $Document);
        return [$Document, $ApiRequestUris];
    }

    /**
     * @depends testSetRequestUris
     */
    public function testGetRequestUris($data)
    {
        list($Document, $ApiRequestUris) = $data;
        $this->assertEquals($ApiRequestUris, $Document->getRequestUris());
        $Document->setApiName('api-update');
        $this->assertEquals('dev', $Document->getRequestUris()->get('dev')->getType());
        $this->assertEquals('http://test.delete', $Document->getRequestUris()->get('dev')->getUri());
        $this->assertEquals('desc', $Document->getRequestUris()->get('dev')->getDesc());
    }

    public function testResponse()
    {
        $Document       = new Document($this->ApiStore);
        $Document->setResponseBuilder(new ApiResponseSigned());
        $Document->setApiName('api-fixed');
//         var_dump($Document->response()->getBody()->getContents());exit;
        $this->assertInstanceOf(TextResponse::class, $Document->response());
    }
}