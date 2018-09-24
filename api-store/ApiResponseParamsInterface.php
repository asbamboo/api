<?php
namespace asbamboo\restfulApi\apiStore;

use asbamboo\http\ResponseInterface;

/**
 * 一个api请求接口的响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiResponseParamsInterface
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
    public function setFormat(string $format = self::FORMAT_JSON) : ApiResponseParamsInterface;

    /**
     * 生成响应数据
     */
    public function makeResponse() : ResponseInterface;
}
