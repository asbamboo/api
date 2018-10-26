<?php
namespace asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed;

use asbamboo\api\apiStore\ApiResponseInterface;
use asbamboo\api\apiStore\ApiRequestParamsAbstract;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
class RequestParams extends ApiRequestParamsAbstract
{
    /**
     * api名称
     *
     * @example eval:ucfirst("api版本")
     * @range eval:"api版本"
     * @desc eval:"api版本"
     * @var string
     */
    private $api_name;

    /**
     * @range v1.0.0-v2.0.0
     * @required 非必须
     * @common
     * @desc api版本
     * @var 文本
     */
    private $version   = 'v1.0.0';

    /**
     * 表示需要接口返回什么格式的数据
     *
     * @var string
     */
    private $format = ApiResponseInterface::FORMAT_JSON;

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

