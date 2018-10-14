<?php
namespace asbamboo\api\exception;

/**
 * 无效的签名
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
class InvalidSignException extends ApiException
{
    public function __construct(string $message="无效的签名。", $code = Code::INVALID_SIGN, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}