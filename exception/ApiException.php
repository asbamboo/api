<?php
namespace asbamboo\api\exception;

/**
 * API 接口所有的异常继承这个类
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class ApiException extends \Exception
{
    public function __construct(string $message="系统发生异常。", $code = Code::SYSTEM_EXCEPTION, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
