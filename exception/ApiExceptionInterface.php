<?php
namespace asbamboo\api\exception;

use asbamboo\api\apiStore\ApiResponseParamsInterface;

/**
 * API 接口所有的异常继承这个类
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ApiExceptionInterface
{
    /**
     * 设置api响应结果的data参数
     *
     * @param ApiResponseParamsInterface $ApiResponseParams
     * @return ApiExceptionInterface
     */
    public function setApiResponseParams(ApiResponseParamsInterface $ApiResponseParams) : ApiExceptionInterface;

    /**
     * 返回api响应结果的data参数
     *
     * @return ApiResponseParamsInterface|NULL
     */
    public function getApiResponseParams() : ?ApiResponseParamsInterface;
}
