<?php
namespace asbamboo\api\exception;

/**
 * 没有找到请求的api时
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class NotFoundApiException extends ApiException
{
    public function __construct(string $message="不好意思，你访问的API不存在。", \Exception $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}