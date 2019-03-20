asbamboo/api 接口访问
============================

索引
-------------------

#. Controller_
#. 接口的帮助文档_
#. 使用接口调试工具_
#. 调用接口_
#. 示例_

Controller
----------------------------

*asbamboo\\api\\Controller 以下简称 Controller*

为了使asbamboo/api适合嵌入到你原有的项目中，asbamboo/api模块没有提供直接用于http请求的(与url对应的)脚本程序。你应该使用 Controller 类，自定义http调用接口、查看接口文档、调试接口的三个入口url程序。你可以参考 `asbamboo/openpay`_ 与 `asbamboo/framework-demo`_ 的实现。

Controller类的构造方法(__construct)有三个参数:

* $ApiStore 指定仓库。（asbamboo/api 中提供了 asbamboo\\api\\apiStore\\ApiStore 类）

* $Request http请求信息。（asbamboo/api 中提供了 asbamboo\\http\\ServerRequest 类）

* $ApiResponse 响应值处理器，默认使用 asbamboo\\api\\apiStore\\ApiResponse

在实例化Controller后，首先应该先调用setContainer方法，指定现在使用的容器（Psr\Container\ContainerInterface）。这个容器必须返回下列服务：

:$this->Container->get($class): $class 指 `api接口逻辑处理类`_
:$this->Container->get(DocumentInterface\:\:class): 文档工具类（asbamboo/api 中提供了 asbamboo\\api\\document\\Document），如果不适用文档工具或调试工具可以忽略它。
:$this->Container->get(ApiRequestUrisInterface\:\:class): 接口请求环境url说明类(asbamboo/api 中提供了 asbamboo\\api\\apiStore\\ApiRequestUris)，如果不适用文档工具或调试工具可以忽略它。
:$this->Container->get(RouterInterface\:\:class): 用于生成测试请求地址url(asbamboo/api 中提供了 asbamboo\\router\\Router)，如果不适用文档工具可以忽略它。
:$this->Container->get(TestInterface\:\:class): 用于测试工具生成请求参数。(asbamboo/api 中提供了 asbamboo\\api\\tool\\test\\Test)，如果不适用调试工具可以忽略它。

接口的帮助文档
----------------

doc 方法用于生成在线文档html页面：

public function doc(string $document_name = 'Asbamboo API Documnet', string $version = '', string 

$api_name = '') : ResponseInterface

* $document_name 文档名称。
* $version 接口的版本。$version 等于空字符串时，默认最高版本。
* $api_name `接口名称`_。$api_name 等于空字符串时，文档页面仅列出api列表

doc 方法返回 asbamboo\http\Response 实例。[`asbamboo/http`_]

使用接口调试工具
--------------------

testTool方法用于生成接口调试工具html页面:

public function testTool(string $tool_name = 'Asbamboo API Testing', string $version = '', string $api_name = '', string $uri = '') : ResponseInterface

* $tool_name 调试工具名称
* $version 接口版本 
* $api_name `接口名称`_
* $uri 接口请求地址

testTool 方法返回 asbamboo\http\Response 实例。[`asbamboo/http`_]

调用接口
---------------

api 方法用于接口请求：

public function api(string $version, string $api_name) : ResponseInterface;

* $version 接口版本, 如果是空字符串， 那么默认最高版本优先。

* $api_name `接口名称`_

api 方法返回 asbamboo\http\Response 实例。[`asbamboo/http`_]

为了能够在api接口处理时做一些（例如记录日志）事情，api方法运行过程中将触发以下事件，你可以监听并做响应的处理：（`asbamboo/event`_）

* api.controller 调用 api 方法时都会触发。它传递三个参数。

    * 当前Controller实例，即$this（asbamboo\api\Controller）
    * api版本，即$version
    * api名称，即$api_name

* api.pre.exec `api接口逻辑处理类`_ 运行api接口逻辑之前触发这个事件。它会传递以下参数。

    * api接口逻辑处理类的实例, $Api。(asbamboo\\api\\apiStore\\ApiClassInterface)
    * api `接口请求参数映射类`_, $ApiRequestParams。(asbamboo\\api\\apiStore\\ApiRequestParamsInterface)
    * http请求信息，$this->Request。(asbamboo\\http\\ServerRequestInterface)

* api.after.exec `api接口逻辑处理类`_ 运行api接口逻辑之后，api方法返回响应值之前，触发这个事件。他会传递以下参数。

    * api接口逻辑处理类的实例，$Api。(asbamboo\\api\\apiStore\\ApiClassInterface)
    * api `接口响应值参数映射类`_，$ApiResponseParams。(asbamboo\\api\\apiStore\\ApiResponseParamsInterface)
    * api响应值处理类，$ApiResponse。(asbamboo\\api\\apiStore\\ApiResponseInterface)
    * api响应值，$Response。(asbamboo\http\ResponseInterface) [`asbamboo/http`_]

示例
--------------------

以下是 `asbamboo/openpay`_ 使用示例并不能运行，它只是描述Controller的三个方法大概时如何调用的。

::

    <?php

    use asbamboo\di\Container;
    use asbamboo\di\ServiceMappingCollection;
    use asbamboo\router\RouteCollection;
    use asbamboo\router\Router;
    use asbamboo\http\ServerRequest;
    use asbamboo\api\Controller;

    // 只要时psr4规范的container应该都可以使用[https://www.php-fig.org/psr/psr-4/]
    $Container          = new Container(new ServiceMappingCollection());

    $RouteCollection    = new RouteCollection();
    $Router             = new Router($RouteCollection);
    $ApiStore           = new ApiStore('/xxxx/api-store');
    $Request            = new ServerRequest();
    $ApiController      = new Controller($ApiStore, $Request);
    $ApiController->setContainer($Container);

    // 调用api接口
    $ApiController->api($version, $api_name);

    // 查看api文档
    $ApiController->doc($document_name, $version, $api_name);

    // 调试工具
    $ApiController->testTool($$tool_name, $version, $api_name, $uri);


.. _asbamboo/openpay: http://github.com/asbamboo/openpay
.. _asbamboo/framework-demo: http://github.com/asbamboo/framework-demo
.. _api接口逻辑处理类: how_to_create_api/api_class.rst
.. _接口名称: api接口逻辑处理类_
.. _接口请求参数映射类: how_to_create_api/request_params.rst
.. _接口响应值参数映射类: how_to_create_api/response_params.rst
.. _asbamboo/http: http://github.com/asbamboo/http
.. _asbamboo/event: http://github.com/asbamboo/event