asbamboo/api 接口编写(注释转换为文档的规则)
===============================================

asbamboo/api 会解析逻辑处理类的类注释块、请求参数映射类的各个属性的注释块、响应参数列表映射类的各个属性注释块、`响应值元信息类`_ 的各个属性注释块，生成接口在线文档。

逻辑处理类的类注释解析说明:

:@name: 接口名称（非接口请求时的名字，是文档说明中描述接口用途的接口名称）
:@desc: 接口说明描述描述
:@uris: 接口请求的url 

    这个注释用于在在线文档与调试工具中显示接口请求的uri
    
    如果有多个接口请求的环境需要分多行列出

    每一行uri信息的格式是 uri=uri,desc=示例,type=test。其中type只能时（product或者test或者develop）

    ::
    
        /**
         * @uris type=develop,uri=http://test.delete.dev,desc=开发请求环境地址
         * @uris type=product,uri=http://test.delete.com,desc=生成请求环境地址
         */

    如果接口没有单独配置@uris标记，那么将使用全局的asbamboo\\api\\apiStore\\ApiRequestUris信息来生成文档中的 url请求地址

:@request: `指定接口参数映射类`_
:@response: `指定接口响应值映射类`_
:@delete: 如果该接口应该已经被删除的话需要在注释说明（* @delete true）

请求参数映射类的注释解析说明:

:@desc: 参数说明
:@var: 参数类型
:@required: 是否必填
:@range: 取值范围
:@example: 请求值示例


响应参数列表映射类的注释解析说明:

:@var: 响应值类型
:@desc: 响应值说明
:@range: 取值范围
:@example: 响应值示例

`响应值元信息类`_ 的注释解析说明:

:@var: 响应值类型
:@desc: 响应值说明
:@range: 取值范围
:@example: 响应值示例

注释标记如果需要输入多行，那么需要在每行注释的开头定义注释标记如:

::

    <?php

    ...
    
        /**
         * @desc 聚合平台服务器主动通知接入应用指定的http url, 这个url上的程序处理成功后应该返回响应"SUCCESS"。
         * @desc 聚合平台如果没有收到"SUCCESS"响应的话，会启动重复机制, 24小时内会重复发送多次 当收到"SUCCESS"响应后停止重发）
         * @desc 如果超过24小时仍然没有处理成功的话，只能通过trade.query接口查询支付状态。
         * @example http://api.test.asbamboo.com/notify/trade/pay
         * @var string(200)
         */
    ...

有时候注释信息需要通过脚本动态解析，比如 `asbamboo/openpay`_ 中 *trade.pay* 的channel参数时可变的，这时需要使用eval。

eval:expression 在文档解析时被执行成 eval(expression)。

::

    <?php
    namespace asbamboo\openpay\apiStore\parameter\v1_0\trade\pay;

    ...
    
    class PayRequest extends ApiRequestParamsAbstract
    {
        ...
    
        /**
         * @desc 支付渠道
         * @example eval:asbamboo\openpay\apiStore\parameter\v1_0\trade\pay\Doc::channelExample();
         * @range eval:asbamboo\openpay\apiStore\parameter\v1_0\trade\pay\Doc::channelRange()
         * @required 必须
         * @var string(45)
         */
        protected $channel;
        
    ...

有时候可能需要需要一篇完整的文档去说明某个字段如何使用（比如api的签名参数，时如何生成的），这时可以使用url标记。

* [url]http://httphost.com[/url]表示需要把这段注释解析成<a href="http://httphost.com">http://httphost.com</a>

* [url:http://httphost.com]这个是链接[/url]表示需要把这段注释解析成<a href="http://httphost.com">这个是链接</a>

下面的示例使用了eval 与 url 标记的组合:

::

    <?php

    ...
    
        /**
         * api接口处理程序会按规则在服务端生成sign，然后与请求参数sign做比较
         *  - 未安装规则生成sign被认为可能是恶意请求
         *
         * @desc eval:"签名字符串 [url:" . Parameter::API_DOC_SIGN_URL . "]如何生成?[/url]"
         * @required 必须
         * @common
         * @var string
         * @example xxxxxxxxxxxxxxxxxxxxxxxxxx
         * @range 请查看签名规则
         */
        protected $sign = '';

    ...

    
.. _响应值元信息类: ../advanced/response.rst
.. _指定接口参数映射类: request_params.rst
.. _指定接口响应值映射类: response_params.rst
.. _asbamboo/openpay: http://github.com/asbamboo/openpay
