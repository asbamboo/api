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


* public function api(string $version, string $api_name) : ResponseInterface;

    api 方法用于接口请求：
    
    * $version 接口版本, 如果是empty， 那么默认最新版本优先。

    * $api_name 接口名称。



.. _composer: https://getcomposer.org
.. _帮助文档: docs/index.rst
.. _asbamboo/http: https://www.github.com/asbamboo/http