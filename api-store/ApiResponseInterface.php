<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface;

/**
 * 一个api请求接口的响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiResponseInterface
{
    /**
     *
     * @var string
     */
    const FORMAT_JSON   = 'json';

    /**
     * 设置响应合适
     *
     * @param string $format
     */
    public function setFormat(string $format) : ApiResponseInterface;

    /**
     * 返回响应格式
     *
     * @return string
     */
    public function getFormat() : string;

    /**
     *
     * @return ResponseFormatManagerInterface
     */
    public function getResponseFormatManager() : ResponseFormatManagerInterface;

    /**
     * 返回表示响应值元信息的类的实例
     *
     * @return ApiResponseMetadataInterface
     */
    public function getApiResponseMetadata() : ApiResponseMetadataInterface;

    /**
     * 生成响应数据
     */
    public function makeResponse(ApiResponseParamsInterface $params) : ResponseInterface;
}
