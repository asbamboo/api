<?php
namespace asbamboo\api\apiStore\validator;

use asbamboo\api\exception\ApiException;

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
     *
     * @throws ApiException
     * @return bool
     */
    public function check() : bool;
}
