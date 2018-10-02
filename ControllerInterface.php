<?php
namespace asbamboo\api;

use asbamboo\http\ResponseInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ControllerInterface
{
    /**
     * 查看api文档
     *  - 通过解析api类相关的注释生成api文档
     *
     * @param string $version
     * @param string $api_name
     * @return ResponseInterface
     */
    public function doc(string $version = '', string $api_name = ''): ResponseInterface;

    /**
     * api调试工具
     * 响应结果是一个调试表单
     * 通过调试页面可以确定正确请求时应该需要的请求参数，和响应结果
     *
     * @param string $version
     * @param string $api_name
     * @param string $uri
     * @return ResponseInterface
     */
    public function testTool(string $version = '', string $api_name = '', string $uri) : ResponseInterface;

    /**
     * http请求一个api接口, 获取一个响应信息
     *
     * @param string $version
     * @param string $api_name
     * @return ResponseInterface
     */
    public function api(string $version, string $api_name) : ResponseInterface;
}