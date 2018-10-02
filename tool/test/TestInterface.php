<?php
namespace asbamboo\api\tool\test;

use asbamboo\http\ResponseInterface;
use asbamboo\api\document\DocumentInterface;

/**
 * api接口调试工具
 * 调试工具是建立在文档工具基础上的，生成api请求表单，进行调试的工具。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
interface TestInterface
{
    /**
     * 设置文档工具
     *
     * @param DocumentInterface $Document
     * @return TestInterface
     */
    public function setDocument(DocumentInterface $Document) : TestInterface;

    /**
     * 返回文档工具
     *
     * @return DocumentInterface
     */
    public function getDocument() : DocumentInterface;

    /**
     * 设置测试用的uri
     *
     * @return TestInterface
     */
    public function setTestUri(string $uri) : TestInterface;

    /**
     * 返回测试用的uri
     *
     * @return string
     */
    public function getTestUri() : string;

    /**
     * http响应
     * @return ResponseInterface
     */
    public function response() : ResponseInterface;
}
