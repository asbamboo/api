<?php
namespace asbamboo\api\document;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiRequestUrisInterface;
use asbamboo\api\exception\NotFoundApiException;
use asbamboo\api\apiStore\ApiResponseInterface;

/**
 * 文档生成器
 *  - 根据获取的api仓库中api类的注释信息解析生成文档。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
interface DocumentInterface
{
    /**
     * 设置文档的名称
     *
     * @param string $name
     * @return DocumentInterface
     */
    public function setDocumentName(string $name) : DocumentInterface;

    /**
     * 返回文档的名称
     *
     * @return string
     */
    public function getDocumentName() : string;

    /**
     * 设置当前需要获取那个版本的文档
     *
     * @param string $version
     * @return DocumentInterface
     */
    public function setVersion(string $version) : DocumentInterface;

    /**
     * 获取当前返回的是哪个版本的文档
     *
     * @return string
     */
    public function getVersion() : string;

    /**
     * 返回支持的api版本列表
     *
     * @return array
     */
    public function getApiVersions() : array;

    /**
     * 返回api列表
     *
     * @return ApiClassDocInterface[]
     */
    public function getApiLists() : array;

    /**
     * 设置当前需要获取哪个接口的文档
     *
     * @param string $api_name
     * @return DocumentInterface
     */
    public function setApiName(string $api_name) : DocumentInterface;

    /**
     * 获取当前返回的是哪个接口的文档
     *
     * @return string
     */
    public function getApiName() : string;

    /**
     * 获取一个api接口文档详情信息
     *
     * @throws NotFoundApiException
     * @return ApiClassDocInterface
     */
    public function getApiDetail() : ApiClassDocInterface;

    /**
     * 设置测试工具页面的uri
     *
     * @param string $uri
     * @return DocumentInterface
     */
    public function setTestToolUri(string $uri) : DocumentInterface;

    /**
     * 返回测试工具页面的uri
     *  - 当没有使用测试工具是返回null
     *
     * @return string|NULL
     */
    public function getTestToolUri() : ?string;

    /**
     * 设置api store请求的uri集合
     *
     * @param ApiRequestUrisInterface $ApiRequestUris
     * @return DocumentInterface
     */
    public function setRequestUris(ApiRequestUrisInterface $ApiRequestUris) : DocumentInterface;

    /**
     * 返回api store的uri请求地址（是一个集合，应该包含了测试，正式等各个环境）
     *
     * @return ApiRequestUrisInterface|NULL
     */
    public function getRequestUris() : ?ApiRequestUrisInterface;

    /**
     * 设置响应值构建器
     *
     * @param ApiResponseInterface $ApiResponse
     */
    public function setResponseBuilder(ApiResponseInterface $ApiResponse) : DocumentInterface;

    /**
     * 返回响应值构建器
     *
     * @return ApiResponseInterface
     */
    public function getResponseBuilder() : ApiResponseInterface;

    /**
     * 响应结果
     *
     * @return ResponseInterface
     */
    public function response() : ResponseInterface;
}