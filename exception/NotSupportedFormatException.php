<?php
namespace asbamboo\api\exception;

/**
 * 不支持的api response返回格式。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class NotSupportedFormatException extends ApiException
{
    public function __construct(string $message="不支持的格式。", $code = Code::NOT_SUPPORTED_FORMAT, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}