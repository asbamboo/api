<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\InvalidTimestampException;

/**
 * 请求参数是否在有效时间内验证
 *  - 默认timestamp的值必须时服务器时间的10分钟内，才有效
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
interface TimestampInterface
{
    /**
     * 验证
     *
     * @throws InvalidTimestampException
     * @return bool
     */
    public function check() : bool;
}