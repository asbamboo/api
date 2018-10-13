<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\api\exception\NotSupportedFormatException;
use asbamboo\http\JsonResponse;

/**
 * api响应信息
 *  - 暂时这个类只支持json格式
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
     * @var int|string
     */
    private $code;

    /**
     *
     * @var string
     */
    private $message;

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
     * @see \asbamboo\api\apiStore\ApiResponseInterface::setCode()
     */
    public function setCode($code) : ApiResponseInterface
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
    public function setMessage(string $message) : ApiResponseInterface
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
        $response_data              = [];
        $response_data['code']      = $this->getCode();
        $response_data['message']   = $this->getMessage();
        if(!empty($Params) && !empty($Params->getObjectVars())){
            $response_data['data']   = $Params->getObjectVars();
        }
        return new JsonResponse($response_data);
    }
}
