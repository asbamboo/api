<?php
namespace asbamboo\api\exception;

/**
 * 请求参数验证未通过时抛出这个异常
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
class InvalidArgumentException extends ApiException
{
    public function __construct(string $message="参数无效。", \Exception $previous = null)
    {
        parent::__construct($message, Code::INVALID_ARGUMENT, $previous);
    }
}