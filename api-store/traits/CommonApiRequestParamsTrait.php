<?php
namespace asbamboo\api\apiStore\traits;

use asbamboo\api\apiStore\ApiResponseInterface;

/**
 * api 公共请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
trait CommonApiRequestParamsTrait
{
    /**
     * api名称
     *
     * @common
     * @desc api名称
     * @required 必须
     * @range api列表中支持的名称
     * @var string
     */
    protected $api_name = '';

    /**
     * api版本
     *
     * @common
     * @range api列表中支持的版本
     * @desc api版本。如果没传，表示使用最新的版本
     * @var string
     */
    protected $version = '';

    /**
     * 表示需要接口返回什么格式的数据
     *
     * @common
     * @desc 表示需要接口返回什么格式的数据,仅支持json
     * @range json
     * @var string
     */
    protected $format = ApiResponseInterface::FORMAT_JSON;

    /**
     * api 名称
     *
     * @return string
     */
    public function getApiName() : string
    {
        return $this->api_name;
    }

    /**
     * api 版本
     *
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }

    /**
     * 获取返回格式
     *
     * @return string
     */
    public function getFormat() : string
    {
        return $this->format;
    }
}
