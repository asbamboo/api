<?php
namespace asbamboo\api\document;

/**
 * api接口响应参数的帮助信息
 *  - 响应参数集合
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
interface ApiResponseMetadatasDocInterface extends \Iterator
{
    /**
     * 获取表示响应参数列表的类
     *
     * @return string
     */
    public function getClass() : string;
}