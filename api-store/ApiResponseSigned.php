<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\api\exception\NotSupportedFormatException;
use asbamboo\http\JsonResponse;
use asbamboo\di\ContainerAwareTrait;
use asbamboo\api\apiStore\validator\SignCheckerAbstract;

/**
 * api响应信息(加签名的)
 *  - 暂时这个类只支持json格式
 *
 * 返回值示例:
 *  {"code":"0","message":"success","sign":"912EC803B2CE49E4A541068D495AB570","random":"5c2f132f2c65c","data":{"id":"test_id"}}
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
class ApiResponseSigned extends ApiResponse
{
    use ContainerAwareTrait;

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
            $response_data['data']  = $Params->getObjectVars();
        }

        /**
         * sign
         * @var SignCheckerAbstract $SignChecker
         */
        $response_data['random']    = uniqid();
        $sign_data                  = $response_data;
        $app_security               = '';
        if($this->Container && $SignChecker = $this->Container->get(SignCheckerAbstract::class)){
            $app_security   = $SignChecker->getAppSecurity();
        }
        if(array_key_exists('data', $sign_data)){
            ksort($sign_data['data']);
        }
        ksort($sign_data);
        $sign_data                  = json_encode($sign_data);
        $response_data['sign']      = strtoupper(md5($app_security . $sign_data));

        return new JsonResponse($response_data);
    }
}
