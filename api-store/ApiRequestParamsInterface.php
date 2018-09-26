<?php
namespace asbamboo\api\apiStore;

/**
 * 请求参数管理
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiRequestParamsInterface
{
    /**
     * 用于验证参数是否的输入是否合法
     *  - 如果返回false的话apiClassInterface::exec应该不要返回正常结果。
     *
     * @return bool
     */
    public function validate() : bool;
}