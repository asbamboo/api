<?php
namespace asbamboo\restfulApi;

use asbamboo\http\ResponseInterface;
use asbamboo\restfulApi\apiStore\ApiStoreInterface;
use asbamboo\di\ContainerInterface;
use asbamboo\http\ServerRequestInterface;
use asbamboo\restfulApi\exception\ApiException;
use asbamboo\restfulApi\document\DocumentInterface;
use asbamboo\di\ContainerAwareTrait;
use asbamboo\restfulApi\document\Document;
use asbamboo\api\apiStore\ApiResponse;
use asbamboo\api\apiStore\ApiClassInterface;

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
     * @see \asbamboo\restfulApi\ControllerInterface::api()
     */
    public function api(string $version, string $api_name) : ResponseInterface
    {
        try
        {
            /**
             * @var ApiClassInterface $Api
             */
            $ApiResponse        = new ApiResponse();
            $class              = $this->ApiStore->findApiClass($version, $path);
            $Api                = $this->Container->get($class);
//             $ApiRequestParams   =
            $ApiResponseParams  = $Api->exec($ApiRequestParams);
            $ApiResponse->setCode(0);
            $ApiResponse->setMessage('success');
            $ApiResponse->makeResponse($ApiResponseParams);
        }catch(ApiException $e){
            $result['code']     = $e->getCode();
            $result['message']  = $e->getMessage();
        }finally{
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\restfulApi\ControllerInterface::doc()
     */
    public function doc(string $version = '', string $api_name = ''): ResponseInterface
    {

    }
}