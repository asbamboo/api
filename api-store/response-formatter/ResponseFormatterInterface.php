<?php
namespace asbamboo\api\apiStore\responseFormatter;

use asbamboo\api\apiStore\ApiResponseMetadataInterface;
use asbamboo\http\ResponseInterface;

/**
 * 响应值格式化处理器
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
interface ResponseFormatterInterface
{
    /**
     * 处理方法
     *  - 传入一个响应值元信息
     *  - 返回一个http response 结果
     *
     * @param ApiResponseMetadataInterface $ApiResponseMetadata
     * @return ResponseInterface
     */
    public function handle(ApiResponseMetadataInterface $ApiResponseMetadata) : ResponseInterface;
}