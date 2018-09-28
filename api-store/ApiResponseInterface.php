<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;

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
     *  返回响应格式
     * @return string
     */
    public function getFormat() : string;

    /**
     * 设置响应的的代码编号
     *  - 自由设置字符串或者数组作为编号
     *
     * @param string|int $code
     * @return ApiResponseInterface
     */
    public function setCode($code) : ApiResponseInterface;

    /**
     * 获取响应的的代码编号
     */
    public function getCode()/* : string|int*/;

    /**
     * 设置响应的消息
     *
     * @param string $message
     * @return ApiResponseInterface
     */
    public function setMessage(string $message) : ApiResponseInterface;

    /**
     * 返回响应的消息
     *
     * @return string
     */
    public function getMessage() : string;

    /**
     * 生成响应数据
     */
    public function makeResponse(ApiResponseParamsInterface $params) : ResponseInterface;
}
