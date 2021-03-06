<?php
namespace asbamboo\api\document;

/**
 * api接口请求参数的帮助信息
 *  - 请求参数集合
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
interface ApiRequestParamsDocInterface extends \Iterator
{
    /**
     * 获取表示请求参数列表的类
     *
     * @return string
     */
    public function getClass() : string;
}