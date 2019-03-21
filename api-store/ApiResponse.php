<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface;
use asbamboo\api\apiStore\responseFormatter\ResponseFormatManager;
use asbamboo\api\apiStore\responseFormatter\JsonResponseFormatter;

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
     * @var ResponseFormatManagerInterface
     */
    private $ResponseFormatManager;

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
     * 自定义设置响应值格式化处理器
     *
     * @param ResponseFormatManagerInterface $ResponseFormatManager
     * @return ApiResponseInterface
     */
    public function setResponseFormatManager(ResponseFormatManagerInterface $ResponseFormatManager) : ApiResponseInterface
    {
        $this->ResponseFormatManager    = $ResponseFormatManager;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::getResponseFormatManager()
     */
    public function getResponseFormatManager() : ResponseFormatManagerInterface
    {
        if(is_null($this->ResponseFormatManager)){
            $ResponseFormatManager  = new ResponseFormatManager();
            $ResponseFormatManager->appendHandler(self::FORMAT_JSON, JsonResponseFormatter::class);
            $this->setResponseFormatManager($ResponseFormatManager);
        }
        return $this->ResponseFormatManager;
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

        $this->getApiResponseMetadata()->setData($Params);

        $ResponseFormatter  = $this->getResponseFormatManager()->getHandler($this->getFormat());
        return $ResponseFormatter->handle($this->getApiResponseMetadata());
    }
}
