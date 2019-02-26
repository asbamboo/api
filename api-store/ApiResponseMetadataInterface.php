<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\JsonResponse;

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
     * 设置 ApiResponse 返回的各个接口不一样的响应数据信息
     *
     * @return ApiResponseParamsInterface
     */
    public function setData(ApiResponseParamsInterface $ApiResponseParams) : ApiResponseMetadataInterface;

    /**
     * 获取 ApiResponse 返回的各个接口不一样的响应数据信息
     *
     * @return ApiResponseParamsInterface
     */
    public function getData() : ?ApiResponseParamsInterface;

    /**
     * 返回JsonResponse类型的响应信息。
     *
     * @return JsonResponse
     */
    public function toJsonResponse() : JsonResponse;
}