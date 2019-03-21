<?php
namespace asbamboo\api\apiStore;

/**
 * API RESPONSE 响应元信息
 *  - 每个接口有每个接口不同的data响应
 *  - 每个接口有每个接口相同的响应格式
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月26日
 */
interface ApiResponseMetadataInterface
{
    /**
     * 设置状态码
     *  - 传入string，或者能通过 (string) 转换的变量
     *
     * @param string $code
     * @return ApiResponseMetadataInterface
     */
    public function setCode($code) : ApiResponseMetadataInterface;

    /**
     * 返回状态码
     *
     * @return string
     */
    public function getCode() : string;

    /**
     * 设置与状态码setCode对应的文本描述
     *
     * @param string $message
     * @return ApiResponseMetadataInterface
     */
    public function setMessage(string $message) : ApiResponseMetadataInterface;

    /**
     * 返回与状态码getCode对应的文本描述
     *
     * @return string
     */
    public function getMessage() : string;


    /**
     * 设置 ApiResponse 返回的各个接口不一样的响应数据信息
     *
     * @return ApiResponseParamsInterface
     */
    public function setData(?ApiResponseParamsInterface $ApiResponseParams) : ApiResponseMetadataInterface;

    /**
     * 获取 ApiResponse 返回的各个接口不一样的响应数据信息
     *
     * @return ApiResponseParamsInterface
     */
    public function getData() : ?ApiResponseParamsInterface;
}