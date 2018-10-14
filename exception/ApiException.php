<?php
namespace asbamboo\api\exception;

use asbamboo\api\apiStore\ApiResponseParamsInterface;

/**
 * API 接口所有的异常继承这个类
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class ApiException extends \Exception implements ApiExceptionInterface
{
    /**
     * api响应结果的data参数
     *
     * @var ApiResponseParamsInterface
     */
    private $ApiResponseParams;

    /**
     *
     * @param string $message
     * @param int|string $code
     * @param \Exception $previous
     */
    public function __construct(string $message="系统发生异常。", $code = Code::SYSTEM_EXCEPTION, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\exception\ApiExceptionInterface::setApiResponseParams()
     */
    public function setApiResponseParams(ApiResponseParamsInterface $ApiResponseParams) : ApiExceptionInterface
    {
        $this->ApiResponseParams    = $ApiResponseParams;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\exception\ApiExceptionInterface::getApiResponseParams()
     */
    public function getApiResponseParams() : ?ApiResponseParamsInterface
    {
        return $this->ApiResponseParams;
    }
}
