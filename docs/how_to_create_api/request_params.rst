asbamboo/api 接口编写(创建api接口参数映射类)
===============================================

api接口逻辑处理类接收的参数，是参数映射关系类的实例。

定义参数映射类
------------------------------

参数映射关系类的文件路径默认应该是 {$接口类名（首字母要换成小写）}/RequestParams.php，如图所示：

 .. image:: ../images/request_params_1.png

也可以通过注释块@request 自定义参数映射关系类：

::

    <?php
    namespace asbamboo\openpay\apiStore\handler\v1_0\trade;
    
    ...
    
    /**
     * @name 交易支付
     * ...
     * @request asbamboo\openpay\apiStore\parameter\v1_0\trade\pay\PayRequest
     * ...
     */
    class Pay implements ApiClassInterface
    {
        ...

参数映射类必须实现 asbamboo\\api\\apiStore\\ApiRequestParamsInterface:

* public function __construct(ServerRequest $Request);

    构造方法接收的参数是服务端接收的http request请求信息。`asbamboo/http`_

    $Request->getRequestParams()请求获取到请求参数的数组结构。

asbamboo/api中 asbamboo\\api\\apiStore\\ApiRequestParamsAbstract 类处理了请求参数解析，你可以继承这个抽象类。

* 这个抽象类的构造方法__construct处理了http请求参数与类的属性关系的映射

* 你可以通过方发 get{属性名}() 来获取接口的参数。


继承 asbamboo\\api\\apiStore\\ApiRequestParamsAbstract 的参数映射关系类：

* 你需要在类中定义属性（表示接口接收的参数）。

* 每个属性的注释块将被用于 `生成在线文档`_ 。

    :@desc: 参数说明
    :@var: 参数类型
    :@required: 是否必填
    :@range: 取值范围
    :@example: 请求值示例
    
* 你可以将属性的可访问性设置为private，在private的时候 你可以通过方法(get+属性名)，来获取该参数的值。

内置的几个traits说明
-------------------------

请求参数映射类示例
-------------------



.. _asbamboo/http: http://github.com/asbamboo/http
.. _生成在线文档: comments_to_document.rst