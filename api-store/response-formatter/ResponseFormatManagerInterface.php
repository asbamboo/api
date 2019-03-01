<?php
namespace asbamboo\api\apiStore\responseFormatter;

/**
 * api响应值格式化管理器
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
interface ResponseFormatManagerInterface
{
    /**
     * 添加一个名为$format_name的响应值格式化处理器类到管理器实例
     *
     * @param string $format_name 格式化名称
     * @param string $formatter_class 格式化处理类名
     * @return ResponseFormatManagerInterface
     */
    public function appendHandler(string $format_name, string $formatter_class) : ResponseFormatManagerInterface;

    /**
     * 从管理器实例移除一个名为$format_name的响应值格式化处理器类
     *
     * @param string $format_name
     * @return ResponseFormatManagerInterface
     */
    public function removeHandler(string $format_name) : ResponseFormatManagerInterface;

    /**
     * 返回管理器实例是否包含名为$format_name的响应值格式化处理器
     *
     * @param String $format_name
     * @return bool
     */
    public function hasHandler(String $format_name) : bool;
    /**
     * 返回一个名为$format_name的响应值格式化处理器
     *
     * @param String $format_name 响应值格式名
     * @return ResponseFormatterInterface
     * @throws \asbamboo\api\exception\NotSupportedFormatException
     */
    public function getHandler(string $format_name) : ResponseFormatterInterface;
}