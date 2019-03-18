asbamboo/api
============================

asbamboo/api 是用来简化Web API接口开发一个辅助模块。

asbamboo/api 能：

* 解析代码注释，自动生成API文档。
* 提供了Api调试工具，帮助Api对接开发人调试接口。
* 提供了签名验证逻辑，让开发者只需要专注于接口程序相关代码的开发。

以下项目使用了 asbamboo/api 模块，供你参考：

http://www.github.com/asbamboo/framework-demo （asbamboo/framework 示例）

http://www.github.com/asbamboo/openpay （asbamboo/openpay 聚合支付API）

**更多说明请看** `帮助文档`_

安装与使用：

通过 `composer`_ 管理项目对 asbamboo/api 库的依赖

::

    composer require asbamboo/api

接口编写：

一个Web API接口应该对应一个 asbamboo\\api\\apiStore\\ApiClassInterface 实现类:

* public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface;

    exec 方法用于处理接口程序的逻辑:

    * $Params 接口接收到的参数

        应该在接口类所在目录下，建立一个与接口名相同的文件夹，在该文件夹下创建RequestParams类（或者在接口类的注释块中使用@request注释声明RequestParams类的名称）

        RequestParams类实现asbamboo\\api\\apiStore\\ApiRequestParamsInterface

        RequestParams类用来声明该接口接受的请求参数列表。

    * 接口返回的响应值

        应该在接口类所在目录下，建立一个与接口名相同的文件夹，在该文件夹下创建ResponseParams类（或者在接口类的注释块中使用@response注释声明ResponseParams类的名称）

        ResponseParams类实现asbamboo\\api\\apiStore\\ApiResponseParamsInterface

        ResponseParams类用来声明接口响应的参数列表。

通过 asbamboo\\api\\Controller 调用接口、查看文档、调试接口。

* public function __construct(ApiStoreInterface $ApiStore, ServerRequestInterface $Request, ApiResponseInterface $ApiResponse = null)

    构造方法必须要传递：

    * $ApiStore API仓库管理类，用于获取处理API接口程序的类

        * public function getNamespace() : string;

            获取api仓库的命名空间

        * public function getDir() : string;

            获取api仓库的文件目录

        * public function findApiClass(string $version, string $api_name) : string;

            获取处理接口名为$api_name的版本（$version）的接口程序处理类

        * public function findApiVersions(int $sort_type = 0) : array;

            返回所有的api版本列表

        asbamboo/api 模块内置有 asbamboo\\api\\apiStore\\ApiStore 类， 该类的构造方法需要参数：

        * $namespace api仓库的命名空间
        * $dir api仓库的文件目录

    * $Request 当前Http请求信息，可以使用 `asbamboo/http`_ 模块内的 asbamboo\\http\\ServerRequest

* public function api(string $version, string $api_name) : ResponseInterface;

    api 方法用于接口请求：
    
    * $version 接口版本, 如果是empty， 那么默认最新版本优先。

    * $api_name 接口名称。

* public function doc(string $document_name = 'Asbamboo API Documnet', string $version = '', string $api_name = '') : ResponseInterface

    doc 方法用于在线文档html页面：

    * $document_name 文档名称
    * $version 接口的版本
    * $api_name 接口名称。

* public function testTool(string $tool_name = 'Asbamboo API Testing', string $version = '', string $api_name = '', string $uri = '') : ResponseInterface

    testTool 方法时接口调试工具html页面:
    
    * $tool_name 调试工具名称
    * $version 接口版本
    * $api_name 接口名称
    * $uri 接口请求地址


接口版本说明
----------------

接口(asbamboo\\api\\Controller各方法中)的版本参数($version)使用字母v开头后面跟随版本号，如（v1.0,v2.0,...）

在接口仓库中，版本的目录应该是版本号($version)参数的符号点(".")修改为下滑下("_") 如(v1_0, v2_0, ...)

在接口的命名空间声明是应该把版本号($version)参数的符号点(".")修改为下滑下("_") 如(v1_0, v2_0, ...)


Api接口仓库说明（ApiStore）
-------------------------------

Api接口控制器说明(ApiController)
-----------------------------------

Api接口文档解析说明
----------------------------------


Api调试工具说明
----------------------------------



.. _composer: https://getcomposer.org
.. _帮助文档: docs/index.rst
.. _asbamboo/http: https://www.github.com/asbamboo/http