<?php
namespace asbamboo\api\tool\test;

use asbamboo\api\document\DocumentInterface;
use asbamboo\http\ResponseInterface;
use asbamboo\http\TextResponse;
use asbamboo\api\view\TemplateInterface;
use asbamboo\api\view\Template;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
class Test implements TestInterface
{
    /**
     *
     * @var DocumentInterface
     */
    private $Document;

    /**
     * 测试用的请求uri
     *
     * @var string
     */
    private $test_uri;

    /**
     *
     * @var string
     */
    private $Template;

    /**
     *
     * @param string $template
     */
    public function __construct(TemplateInterface $Template = null)
    {
        $this->Template     = $Template;
        if(is_null($this->Template)){
            $this->Template = new Template();
            $this->Template->setPath(implode(DIRECTORY_SEPARATOR, [dirname(dirname(__DIR__)), 'view', 'template', 'tool', 'test.html']));
        }
    }


    /**
     * 设置文档工具
     *
     * @param DocumentInterface $Document
     * @return TestInterface
     */
    public function setDocument(DocumentInterface $Document) : TestInterface
    {
        $this->Document = $Document;
        return $this;
    }

    /**
     * 返回文档工具
     *
     * @return DocumentInterface
     */
    public function getDocument() : DocumentInterface
    {
        return $this->Document;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\tool\test\TestInterface::setTestUri()
     */
    public function setTestUri(string $uri) : TestInterface
    {
        $this->test_uri    = $uri;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\tool\test\TestInterface::getTestUri()
     */
    public function getTestUri() : string
    {
        return $this->test_uri;
    }

    /**
     * http响应
     * @return ResponseInterface
     */
    public function response() : ResponseInterface
    {
        return new TextResponse($this->Template->render([
            'all_versions'       => $this->getDocument()->getApiVersions(),
            'cur_version'        => $this->getDocument()->getVersion(),
            'api_lists'          => $this->getDocument()->getApiLists(),
            'cur_api'            => $this->getDocument()->getApiName() ? $this->getDocument()->getApiDetail() : null,
            'uris'               => $this->getDocument()->getRequestUris(),
            'cur_uri'            => $this->getTestUri(),
        ]));
    }
}