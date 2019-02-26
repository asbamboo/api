<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\JsonResponse;

/**
 * 响应数据元信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月26日
 */
class ApiResponseMetadata implements ApiResponseMetadataInterface
{
    /**
     *
     * @var string
     * @desc 状态码。成功时返回'0'。
     */
    protected $code;

    /**
     * @desc 状态说明。成功时是"success", 错误时返回与code对应的错误信息
     * @var string
     */
    protected $message;

    /**
     * @desc 响应数据信息 见响应信息data具体字段
     * @var data
     */
    protected $data;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::setCode()
     */
    public function setCode($code) : ApiResponseMetadataInterface
    {
        $this->code   = $code;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::getCode()
     */
    public function getCode()/* : string|int*/
    {
        return $this->code;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::setMessage()
     */
    public function setMessage(string $message) : ApiResponseMetadataInterface
    {
        $this->message  = $message;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseInterface::getMessage()
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseMetadataInterface::setData()
     */
    public function setData(ApiResponseParamsInterface $ApiResponseParams) : ApiResponseMetadataInterface
    {
        $this->data = $ApiResponseParams;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseMetadataInterface::getData()
     */
    public function getData() : ?ApiResponseParamsInterface
    {
        return $this->data;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseMetadataInterface::toJsonResponse()
     */
    public function toJsonResponse() : JsonResponse
    {
        $response_data              = [];
        $response_data['code']      = $this->getCode();
        $response_data['message']   = $this->getMessage();
        if(!empty($this->getData()) && !empty($this->getData()->getObjectVars())){
            $response_data['data']   = $this->getData()->getObjectVars();
        }

        return new JsonResponse($response_data);
    }
}