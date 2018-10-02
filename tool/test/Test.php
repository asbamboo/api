<?php
namespace asbamboo\api\tool\test;

use asbamboo\api\document\DocumentInterface;
use asbamboo\http\ResponseInterface;
use asbamboo\http\TextResponse;

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
    private $template;

    /**
     *
     * @param string $template
     */
    public function __construct(string $template = null)
    {
        $this->template     = $template ?? __DIR__ . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'default.html';
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
        $all_versions       = $this->getDocument()->getApiVersions();
        $cur_version        = $this->getDocument()->getVersion();
        $api_lists          = $this->getDocument()->getApiLists();
        $cur_api            = $this->getDocument()->getApiName() ? $this->getDocument()->getApiDetail() : null;
        $uris               = $this->getDocument()->getRequestUris();
        $cur_uri            = $this->getTestUri();
        ob_start();
        include $this->template;
        $html   = ob_get_contents();
        ob_end_clean();
        return new TextResponse($html);
    }
}