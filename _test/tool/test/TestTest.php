<?php
namespace asbamboo\api\_test\tool\test;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiStore;
use asbamboo\api\document\Document;
use asbamboo\api\tool\test\Test;
use asbamboo\api\tool\test\TestInterface;
use asbamboo\api\document\DocumentInterface;
use asbamboo\http\TextResponse;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
class TestTest extends TestCase
{
    public function testSetDocument()
    {
        $namespace      = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir            = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $ApiStore       = new ApiStore($namespace, $dir);
        $Document       = new Document($ApiStore);
        $Test           = new Test();
        $this->assertInstanceOf(TestInterface::class, $Test->setDocument($Document));
        return $Test;
    }

    /**
     *
     * @depends testSetDocument
     * @param TestInterface $Test
     */
    public function testGetDocument(TestInterface $Test)
    {
        $this->assertInstanceOf(DocumentInterface::class, $Test->getDocument());
        return $Test;
    }

    /**
     *
     * @depends testGetDocument
     * @param TestInterface $Test
     */
    public function testSetTestUri(TestInterface $Test)
    {
        $this->assertInstanceOf(TestInterface::class, $Test->setTestUri('uri'));
        return $Test;
    }

    /**
     *
     * @depends testSetTestUri
     * @param TestInterface $Test
     */
    public function testGetTestUri(TestInterface $Test)
    {
        $this->assertEquals('uri', $Test->getTestUri());
        return $Test;
    }

    /**
     *
     * @depends testGetTestUri
     * @param TestInterface $Test
     */
    public function testResponse(TestInterface $Test)
    {
        $this->assertInstanceOf(TextResponse::class, $Test->response());
    }
}
