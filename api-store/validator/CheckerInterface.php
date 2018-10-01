<?php
namespace asbamboo\api\apiStore\validator;

use asbamboo\api\exception\ApiException;
use asbamboo\api\apiStore\ApiRequestParamsInterface;
use asbamboo\api\apiStore\ApiClassInterface;

/**
 * 验证器
 *  - 验证请求是否合法
 *  - 如验证签名，验证参数生成的有效时间
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
interface CheckerInterface
{
    /**
     * 验证
     *  - 如果验证不通过，应该抛出异常。
     *  - 在isSupport方法返回false的情况下，不应该调用check方法
     *
     * @throws ApiException
     * @return bool
     */
    public function check() : bool;

    /**
     * 返回验证器，是否支持当前api接口验证
     *  - 比如签名验证, 一个开放的公共api接口可能不需要验证签名。
     *  - 在isSupport方法返回false的情况下，不应该调用check方法
     *
     * @param ApiClassInterface $ApiClass
     * @param ApiRequestParamsInterface $ApiRequestParams
     * @return bool
     */
    public function isSupport(ApiClassInterface $ApiClass, ?ApiRequestParamsInterface $ApiRequestParams = null) : bool;
}
