<?php
namespace asbamboo\api\apiStore;

/**
 * api接口请求的uri信息
 *  - 实现本接口的类作用于文档中请求地址的说明
 *  - 实现本接口的类作用于api测试工具生成请求参数
 * 如果不想适用api测试工具和文档模块，可以不用编写实现本接口的类
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
interface ApiRequestUriInterface
{
    /**
     * 类型
     * @var string
     */
    const TYPE_DEV  = 'develop';    // 开发环境
    const TYPE_TEST = 'test';       // 测试环境
    const TYPE_PROD = 'product';    // 正式环境

    /**
     * 返回api接口请求的uri
     *
     * @return string
     */
    public function getUri() : string;

    /**
     * 简要说明
     *
     * @return string
     */
    public function getDesc() : string;

    /**
     * 类型
     *  - 表示该uri应该适用于那个环境
     *  - develop 开发环境 test 测试环境 product 正式环境
     *
     * @return string
     */
    public function getType() : string;
}