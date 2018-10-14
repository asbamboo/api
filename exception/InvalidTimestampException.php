<?php
namespace asbamboo\api\exception;

/**
 * 请求参数操作有效时间
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
class InvalidTimestampException extends ApiException
{
    public function __construct(string $message="无效的时间戳。", $code = Code::INVALID_TIMESTAMP, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}