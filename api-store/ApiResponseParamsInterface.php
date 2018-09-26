<?php
namespace asbamboo\api\apiStore;

/**
 * 返回结果中的每个参数
 *  - 每个属性应该都是私有的，对象初始化后不允许再改变
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
interface ApiResponseParamsInterface
{
    /**
     * 应该范围get_object_vars($this)
     *
     * @return array|NULL
     */
    public function getObjectVars() : ?array;
}
