<?php
namespace asbamboo\api\document;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiRequestUrisInterface;

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
     * 响应结果
     *
     * @return ResponseInterface
     */
    public function response() : ResponseInterface;
}