<?php
namespace asbamboo\api\document;

/**
 * api接口响应元信息的帮助信息
 *  - 一个响应元信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月26日
 */
interface ApiResponseMetadataDocInterface
{
    /**
     * 字段名称
     *
     * @return string
     */
    public function getName() : string;


    /**
     * 字段示例值
     *  - 示例值会被用来生成演示代码
     *  - "@example"
     *
     * @return mixed
     */
    public function getExampleValue();

    /**
     * 字段类型
     *  - "@var"
     *
     * @return string
     */
    public function getVar() : string;

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
}