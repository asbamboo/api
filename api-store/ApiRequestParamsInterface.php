<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ServerRequest;

/**
 * 请求参数管理
 *  - 这些参数应该在实例初始化化后只能读取，不能重写。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiRequestParamsInterface
{
    /**
     * 构造方法主要作用是生成请求的参数列表
     *  - 这些参数应该在实例初始化化后只能读取，不能重写。
     *
     * @param ServerRequest $Request
     */
    public function __construct(ServerRequest $Request);

    /**
     * api 名称
     *
     * @return string
     */
    public function getApiName() : string;

    /**
     * api 版本
     *
     * @return string
     */
    public function getVersion() : string;
}