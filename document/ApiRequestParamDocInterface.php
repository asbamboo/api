<?php
namespace asbamboo\api\document;

/**
 * api接口请求参数的帮助信息
 *  - 一个参数的帮助信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
interface ApiRequestParamDocInterface
{
    /**
     * 字段名称
     *
     * @return string
     */
    public function getName() : string;

    /**
     * 字段默认值
     *
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * 字段类型
     *  - "@var"
     *
     * @return string
     */
    public function getVar() : string;

    /**
     * 是否必须
     *  - "@required"
     *
     * @return string
     */
    public function getRequired() : string;

    /**
     * 取值范围
     *  - "@range"
     *
     * @return string
     */
    public function getRange() : string;

    /**
     * 描述
     *  - "@desc"
     *
     * @return string
     */
    public function getDesc() : string;

    /**
     * 是否时公共参数
     *  - 如果是公共的参数，那么返回true
     *  - 如果非公共的参数，那么返回false
     *
     * @return bool
     */
    public function isCommon() : bool;
}