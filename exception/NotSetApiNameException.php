<?php
namespace asbamboo\api\exception;

/**
 * 解析生成文档的时候，api class的注释行没有配置 "@name"信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月15日
 */
class NotSetApiNameException extends \Exception
{
    public function __construct(string $message="没有配置api名称。", \Exception $previous = null)
    {
        parent::__construct($message, Code::NOTSET_API_NAME, $previous);
    }
}