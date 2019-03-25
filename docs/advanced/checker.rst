asbamboo/api 进阶（请求参数有效性验证）
=======================================

#. 请求参数过时失效_

#. 使用签名_

#. 自定义参数有效性验证器_

利用 asbamboo/api 提供的一个事件监听器(asbamboo\\api\\eventListener\\ApiPreExecUseCheckerListener)，监听        `api.pre.exec`_ 事件，可以在接口程序的逻辑处理之前，对请求参数的有效性做一些验证。这个事件监听器的构造方法需要参数 $CheckerCollection (asbamboo\api\apiStore\validator\CheckerCollectionInterface)，它是一组参数有效性验证器的集合，它的构造方法如要通过可变参数列表，设置参数有效性验证器(asbamboo\\api\\apiStore\\validator\\CheckerInterface)。asbamboo/api 内，目前提供了两个参数有效性验证器( 请求参数过时失效_、使用签名_ )。

请求参数过时失效
-----------------------------

使用请求参数过时失效验证器，首先 `api接口参数映射类`_ 使用 asbamboo\\api\\apiStore\\traits\\CommonApiRequestTimestampParamsTrait。然后将参数有效性验证器(asbamboo\\api\\apiStore\\validator\\TimestampChecker)加入参数有效性验证器的集合，并使用事件监听器(asbamboo\\api\\eventListener\\ApiPreExecUseCheckerListener)监听 `api.pre.exec`_ 事件。

`api接口参数映射类`_：

::

    <?php
    
    ...
    
    use asbamboo\api\apiStore\ApiRequestParamsAbstract;
    use asbamboo\api\apiStore\traits\CommonApiRequestTimestampParamsTrait;

    ...
    
    class RequestParams extends ApiRequestParamsAbstract
    {
        use CommonApiRequestTimestampParamsTrait;

    ...        

事件监听:

::

    <?php
    
    use asbamboo\api\apiStore\validator\CheckerCollection;
    use asbamboo\http\ServerRequest;
    use asbamboo\api\apiStore\validator\TimestampChecker;
    use asbamboo\event\EventListener;
    
    $CheckerCollection  = new CheckerCollection();
    $Request            = new ServerRequest();
    $TimestampChecker   = new TimestampChecker($Request);
    $CheckerCollection->add($TimestampChecker);

    EventListener::instance()->set(
        'api.pre.exec', 
        'asbamboo\\api\\eventListener\\ApiPreExecUseCheckerListener',
        'onCheck', 
        $CheckerCollection
        null
    );

使用签名
------------------------------

*如何生成签名？*

#. 对所有API请求参数（包括公共参数和业务参数，但除去sign参数、byte[]类型的参数），根据参数名称的ASCII码表的升序排列。如：foo:1, bar:2, foo_bar:3, foobar:4排序后的顺序是bar:2, foo:1, foo_bar:3, foobar:4。

将排序好的参数名和参数值拼装在一起，根据上面的示例得到的结果为：bar2foo1foo_bar3foobar4。
把拼装好的字符串前加上应用的app secret后，使用签名MD5算法生成签名字符串，如：md5(app_secret+bar2foo1foo_bar3foobar4)。

使用请求参数签名验证器。

#. 首先 `api接口参数映射类`_ 使用 asbamboo\\api\\apiStore\\traits\\CommonApiRequestSignParamsTrait。

    如果自定义签名相关的接口参数的名称的话可以不使用这个trait，单需要改变签名参数有效性验证器的相关字段默认值。默认情况下签名相关的参数列表为（app_key，sign）

#. 然后将签名参数有效性验证器加入参数有效性验证器的集合，并使用事件监听器(asbamboo\\api\\eventListener\\ApiPreExecUseCheckerListener)监听 `api.pre.exec`_ 事件。

    签名参数有效性验证器有两种:

    * 固定秘钥（asbamboo\\api\\apiStore\\validator\\SignCheckerByFixedSecurity）。

        这个验证器的构造方法有以下参数:

        :$Request: http请求信息
        :$input_app_key: 请求api接口的应用标识字段名，默认值: app_key。
        :$input_sign: 请求api接口的签名字段名，默认值: sign。
        :$app_security: 用于生成签名的秘钥值(是一个固定的值)，默认值: security。

    * 非固定秘钥（asbamboo\\api\\apiStore\\validator\\SignCheckerAbstract）。

        非固定秘钥需要继承这个抽象类，并实现它的 getAppSecurity 方法，实现获取秘钥的逻辑代码。它的构造方法有以下参数

        :$Request: http请求信息
        :$input_app_key: 请求api接口的应用标识字段名，默认值: app_key。
        :$input_sign: 请求api接口的签名字段名，默认值: sign。

`api接口参数映射类`_：

::

    <?php
    
    ...
    
    use asbamboo\api\apiStore\ApiRequestParamsAbstract;
    use asbamboo\api\apiStore\traits\CommonApiRequestSignParamsTrait;

    ...
    
    class RequestParams extends ApiRequestParamsAbstract
    {
        use CommonApiRequestSignParamsTrait;

    ...

事件监听:

::

    <?php
    
    use asbamboo\api\apiStore\validator\CheckerCollection;
    use asbamboo\http\ServerRequest;
    use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;
    use asbamboo\event\EventListener;
    
    $CheckerCollection  = new CheckerCollection();
    $Request            = new ServerRequest();
    $SignChecker        = new SignCheckerByFixedSecurity($Request);
    $CheckerCollection->add($SignChecker);

    EventListener::instance()->set(
        'api.pre.exec', 
        'asbamboo\\api\\eventListener\\ApiPreExecUseCheckerListener',
        'onCheck', 
        $CheckerCollection
        null
    );
    
自定义参数有效性验证器
-------------------------------

除了使用asbamboo/api内部的签名参数有效性验证器或者timestamp参数有效性验证器外，你可以自定义参数有效性验证器。实现asbamboo\\api\\apiStore\\validator\\CheckerInterface，需要实现两个方法。

* public function check() : bool;

    验证逻辑代码。验证不通过时应该抛出异常(asbamboo\\api\\exception\\ApiException)。
    
* public function isSupport(ApiClassInterface $ApiClass, ?ApiRequestParamsInterface $ApiRequestParams = null) : bool;

    表示这个验证器是否支持参数为($ApiClass，$ApiRequestParams)提供验证服务。如果要验证返回true。
    可以通过这个方法添加只为某个特定的接口做验证的验证器。

实际上 签名参数有效性验证器和timestamp参数有效性验证器，也是这个interface的实现类。
    




.. _api.pre.exec: ../how_to_use_api.rst
.. _api接口参数映射类: ../how_to_create_api/request_params.rst

