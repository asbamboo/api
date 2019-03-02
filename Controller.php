<?php
namespace asbamboo\api;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiStoreInterface;
use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\ApiException;
use asbamboo\api\apiStore\ApiResponse;
use asbamboo\api\document\DocumentInterface;
use asbamboo\api\document\ApiClassDoc;
use asbamboo\event\EventScheduler;
use asbamboo\api\apiStore\ApiRequestUrisInterface;
use asbamboo\api\tool\test\TestInterface;
use asbamboo\api\exception\Code;
use asbamboo\api\apiStore\ApiResponseInterface;
use Psr\Container\ContainerInterface;
use asbamboo\router\RouterInterface;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
class Controller implements ControllerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $Container;

    /**
     * 在 [asbamboo\di\Container($serviceMapping)]时会被调用
     *
     * @param ContainerInterface $Container
     */
    public function setContainer(ContainerInterface $Container) : void
    {
        $this->Container = $Container;
    }

    /**
     *
     * @var ApiStoreInterface
     * @var ServerRequestInterface $Request
     * @var ApiResponseInterface $Request
     */
    private $ApiStore; private $Request; private $ApiResponse;

    /**
     *
     * @param ApiStoreInterface $ApiStore
     * @param ServerRequestInterface $Request
     * @param ApiResponseInterface $ApiResponse
     */
    public function __construct(ApiStoreInterface $ApiStore, ServerRequestInterface $Request, ApiResponseInterface $ApiResponse = null)
    {
        $this->ApiStore         = $ApiStore;
        $this->Request          = $Request;
        $this->ApiResponse      = $ApiResponse;
        if(is_null($this->ApiResponse)){
            $this->ApiResponse  = new ApiResponse();
        }
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
             * 初始化 controller 返回响应需要的相关变量
             *
             * @var ApiResponse $ApiResponse
             * @var ApiResponseParamsInterface|null $ApiResponseParams
             */
            $ApiResponse                = $this->ApiResponse;
            $ApiResponse->getApiResponseMetadata()->setCode(Code::SYSTEM_EXCEPTION);
            $ApiResponse->getApiResponseMetadata()->setMessage('系统异常');
            $ApiResponseParams          = null;

            /**
             * 事件触发 可以通过监听这个事件处理一些事情，比如:写入日志,校验请求参数等
             * 在api模块内，event-listener定义了几个监听器，如果你有需要的话，请使用EventScheduler::instance()->bind 方法绑定事件监听器
             */
            EventScheduler::instance()->trigger(Event::API_CONTROLLER, $this, ...func_get_args());

            /**
             * @var \asbamboo\api\apiStore\ApiClassInterface $Api
             */
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
            $ApiResponse->getApiResponseMetadata()->setCode(Constant::RESPONSE_STATUS_OK);
            $ApiResponse->getApiResponseMetadata()->setMessage(Constant::RESPONSE_MESSAGE_OK);
        }catch(ApiException $e){
            $ApiResponse->getApiResponseMetadata()->setCode($e->getCode());
            $ApiResponse->getApiResponseMetadata()->setMessage($e->getMessage());
            $ApiResponseParams  = $e->getApiResponseParams();
        }

        $response   = $ApiResponse->makeResponse($ApiResponseParams);
        EventScheduler::instance()->trigger(Event::API_AFTER_EXEC, [$Api, $ApiResponseParams, $ApiResponse, $response]);
        return $response;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\ControllerInterface::doc()
     */
    public function doc(string $document_name = 'Asbamboo API Documnet', string $version = '', string $api_name = '') : ResponseInterface
    {
        /**
         *
         * @var DocumentInterface $Document
         */
        $Document       = $this->Container->get(DocumentInterface::class);
        $Document->setDocumentName($document_name);
        $Document->setApiName($api_name);
        $Document->setVersion($version);
        $Document->setRequestUris($this->Container->get(ApiRequestUrisInterface::class));
        $Document->setResponseBuilder($this->ApiResponse);

        /**
         * 测试工具uri
         *
         * @var RouterInterface $Router
         * @var \asbamboo\router\RouteInterface $Route
         * @var \asbamboo\api\apiStore\ApiRequestUriInterface $ApiRequestUri
         */
        if($Document->getApiName() && $Document->getVersion()){
            $Router = $this->Container->get(RouterInterface::class);
            $routes = $Router->getRouteCollection()->getIterator();
            foreach($routes AS $Route){
                if($Route->getCallback() == [$this, 'testTool']){
                    $script_name    = $this->Request->getServerParams()['SCRIPT_NAME'] ?? "";
                    $script_path    = dirname($script_name);
                    $request_path   = $this->Request->getUri()->getPath();
                    $test_tool_uri  = $Route->getPath();
                    if($script_path != '/' && strpos($request_path, $script_name) === 0){
                        $test_tool_uri  = $script_name . $test_tool_uri;
                    }else if($script_path != '/' && strpos($request_path, $script_path) === 0){
                        $test_tool_uri  = $script_path . $test_tool_uri;
                    }

                    foreach($Document->getRequestUris() AS $ApiRequestUri){
                        $test_tool_uri  .= '?uri=' . urlencode($ApiRequestUri->getUri()) . '&version=' . $Document->getVersion() . '&api_name=' . $Document->getApiName();
                        break;
                    }
                    $Document->setTestToolUri($test_tool_uri);
                    break;
                }
            }
        }

        return $Document->response();
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\ControllerInterface::testTool()
     */
    public function testTool(string $document_name = 'Asbamboo API Documnet', string $version = '', string $api_name = '', string $uri = '') : ResponseInterface
    {
        /**
         *
         * @var DocumentInterface $Document
         */
        $Document       = $this->Container->get(DocumentInterface::class);
        $Document->setDocumentName($document_name);
        $Document->setApiName($api_name);
        $Document->setVersion($version);
        $Document->setRequestUris($this->Container->get(ApiRequestUrisInterface::class));
        $Document->setResponseBuilder($this->ApiResponse);

        /**
         *
         * @var TestInterface $Test
         */
        if(empty($uri) && $Document->getRequestUris()){
            foreach($Document->getRequestUris() AS $ApiRequestUri){
                $uri    = $ApiRequestUri->getUri();
                break;
            }
        }
        $Test           = $this->Container->get(TestInterface::class);
        $Test->setDocument($Document);
        $Test->setTestUri($uri);

        return $Test->response();
    }
}