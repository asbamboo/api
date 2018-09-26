<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0;

use asbamboo\api\apiStore\ApiClassAbstract;

/**
 * 测试在2.0.0版本中沿用1.0.0的版本
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiFixed extends ApiClassAbstract
{
    /**
     * HTTP GET
     * 不指定具体id时返回一个列表信息
     * 指定id时返回一个详情信息
     */
    public function get()
    {
        return ['get'];
    }
}