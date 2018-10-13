<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;

/**
 * 和普通响应参数不同
 *  - 这个接口实现的类应该被api response生成一个页面会跳转的响应
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月13日
 */
interface ApiResponseRedirectParamsInterface extends ApiResponseParamsInterface
{
    /**
     * 生成响应实例
     * 这个响应实例的应该能实现页面跳转
     *
     * @return ResponseInterface
     */
    public function makeRedirectResponse() : ResponseInterface;
}