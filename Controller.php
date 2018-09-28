<?php
namespace asbamboo\api;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiStoreInterface;
use asbamboo\di\ContainerInterface;
use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\ApiException;
use asbamboo\di\ContainerAwareTrait;
use asbamboo\api\apiStore\ApiResponse;
use asbamboo\api\document\DocumentInterface;
use asbamboo\api\document\ApiClassDoc;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class Controller implements ControllerInterface
{
    use ContainerAwareTrait;

    /**
     *
     * @var ApiStoreInterface
     * @var ServerRequestInterface $Request
     */
    private $ApiStore; private $Request;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param ContainerInterface $Container
     * @param ServerRequestInterface $Request
     */
    public function __construct(ApiStoreInterface $ApiStore, ServerRequestInterface $Request)
    {
        $this->ApiStore     = $ApiStore;
        $this->Request      = $Request;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\ControllerInterface::api()
     */
    public function api(string $version, string $api_name) : ResponseInterface
    {
        try
        {
            /**
             * @var \asbamboo\api\apiStore\ApiClassInterface $Api
             */
            $ApiResponse                = new ApiResponse();
            $class                      = $this->ApiStore->findApiClass($version, $api_name);
            $Api                        = $this->Container->get($class);
            $ApiDoc                     = new ApiClassDoc($class, $this->ApiStore->getNamespace());
            $api_request_params_class   = $Api->getApiRequestParamsClass();
            $ApiRequestParams           = new $api_request_params_class($this->Request);
            $ApiResponseParams          = $Api->exec($ApiRequestParams);
            if(method_exists($ApiRequestParams, 'getFormat')){
                $ApiResponse->setFormat($ApiRequestParams->getFormat());
            }
            $ApiResponse->setCode(0);
            $ApiResponse->setMessage('success');
        }catch(ApiException $e){
            $ApiResponse->setCode($e->getCode());
            $ApiResponse->setMessage($e->getMessage());
        }finally{
            return $ApiResponse->makeResponse($ApiResponseParams);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\ControllerInterface::doc()
     */
    public function doc(string $version = '', string $api_name = '') : ResponseInterface
    {
        /**
         *
         * @var DocumentInterface $Document
         */
        $Document       = $this->Container->get(DocumentInterface::class);
        $Document->setApiName($api_name);
        $Document->setVersion($version);
        return $Document->response();
    }
}