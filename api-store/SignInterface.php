<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\InvalidSignException;

/**
 * 签名接口
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
interface SignInterface
{
    /**
     * 验证签名
     *
     * @throws InvalidSignException
     * @return bool
     */
    public function check() : bool;
}