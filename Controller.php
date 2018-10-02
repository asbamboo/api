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
use asbamboo\event\EventScheduler;
use asbamboo\api\apiStore\ApiRequestUrisInterface;
use asbamboo\api\tool\test\TestInterface;

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
             * 事件触发 可以通过监听这个事件处理一些事情，比如:写入日志,校验请求参数等
             * 在api模块内，event-listener定义了几个监听器，如果你有需要的话，请使用EventScheduler::instance()->bind 方法绑定事件监听器
             */
            EventScheduler::instance()->trigger(Event::API_CONTROLLER, $this, ...func_get_args());

            /**
             * @var \asbamboo\api\apiStore\ApiClassInterface $Api
             */
            $ApiResponse                = new ApiResponse();
            $class                      = $this->ApiStore->findApiClass($version, $api_name);
            $Api                        = $this->Container->get($class);
            $ApiDoc                     = new ApiClassDoc($class, $this->ApiStore->getNamespace());
            $api_request_params_class   = $ApiDoc->getRequestParamsDoc()->getClass();
            $ApiRequestParams           = new $api_request_params_class($this->Request);

            /**
             * 事件触发 可以通过监听这个事件处理一些事情，比如:写入日志,校验请求参数等
             * 在api模块内，event-listener定义了几个监听器，如果你有需要的话，请使用EventScheduler::instance()->bind 方法绑定事件监听器
             */
            EventScheduler::instance()->trigger(Event::API_PRE_EXEC, [$Api, $ApiRequestParams, $this->Request]);

            $ApiResponseParams          = $Api->exec($ApiRequestParams);
            if(method_exists($ApiRequestParams, 'getFormat')){
                $ApiResponse->setFormat($ApiRequestParams->getFormat());
            }
            $ApiResponse->setCode(Constant::RESPONSE_STATUS_OK);
            $ApiResponse->setMessage(Constant::RESPONSE_MESSAGE_OK);
        }catch(ApiException $e){
            $ApiResponse->setCode($e->getCode());
            $ApiResponse->setMessage($e->getMessage());
//         }catch(\Throwable $e){
//             var_dump($e->__toString());exit;
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
        $Document->setRequestUris($this->Container->get(ApiRequestUrisInterface::class));
        return $Document->response();
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\ControllerInterface::testTool()
     */
    public function testTool(string $version = '', string $api_name = '', string $uri = '') : ResponseInterface
    {
        /**
         *
         * @var DocumentInterface $Document
         */
        $Document       = $this->Container->get(DocumentInterface::class);
        $Document->setApiName($api_name);
        $Document->setVersion($version);
        $Document->setRequestUris($this->Container->get(ApiRequestUrisInterface::class));

        /**
         *
         * @var TestInterface $Test
         */
        $Test           = $this->Container->get(TestInterface::class);
        $Test->setDocument($Document);
        $Test->setTestUri($uri);

        return $Test->response();
    }
}