<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\api\exception\NotSupportedFormatException;

/**
 * api响应信息
 *  - 暂时这个类只支持json格式
 *
 * 返回值示例:
 *  {"code":"0","message":"success","data":{"id":"test_id"}}
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
class ApiResponse implements ApiResponseInterface
{
    /**
     *
     * @var string
     */
    private $format = self::FORMAT_JSON;

    /**
     *
     * @var ApiResponseMetadataInterface
     */
    private $ApiResponseMetadata;

    /**
     *
     * @param ApiResponseMetadataInterface $ApiResponseMetadata
     */
    public function __construct(ApiResponseMetadataInterface $ApiResponseMetadata = null)
    {
        if($ApiResponseMetadata == null){
            $ApiResponseMetadata    = new ApiResponseMetadata();
        }
        $this->ApiResponseMetadata  = $ApiResponseMetadata;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::setFormat()
     */
    public function setFormat(string $format) : ApiResponseInterface
    {
        $this->format   = $format;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::getFormat()
     */
    public function getFormat() : string
    {
        return $this->format;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::getApiResponseMetadata()
     */
    public function getApiResponseMetadata() : ApiResponseMetadataInterface
    {
        return $this->ApiResponseMetadata;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::makeResponse()
     */
    public function makeResponse(?ApiResponseParamsInterface $Params = null): ResponseInterface
    {
        if($Params instanceof ApiResponseRedirectParamsInterface){
            return $Params->makeRedirectResponse();
        }

        if($this->getFormat() != self::FORMAT_JSON){
            throw new NotSupportedFormatException(sprintf('目前Api接口响应格式只允许[%s]', self::FORMAT_JSON));
        }

        if($Params instanceof ApiResponseParamsInterface){
            $this->getApiResponseMetadata()->setData($Params);
        }
        return $this->getApiResponseMetadata()->toJsonResponse();
    }
}
