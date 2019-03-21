asbamboo/api 进阶（自定义调试工具页面）
===========================================

系统生成文档默认模板文件是 view/template/tool/test.html。
要改变默认模板，需要在实例化 asbamboo\api\tool\test\Test 时通过构造方法传递自定义的 $Template（asbamboo\\api\\view\\TemplateInterface）。

* public function setPath(string $path) : TemplateInterface;

    设置模板文件路径

* public function getPath() : string;

    返回模板文件路径

* public function render(array $assign_data = []) : string;

    渲染模板文件，通常返回文档的html。

    可以通过这个方法跳用其他第三方的模板处理库比如(`smarty`_、`twig`_ 等)

    $assign_data 数组键名说明:
    
    :all_versions: 数组格式，所有api版本号。如: [v1.0,v2.0,v3.0]
    
    :cur_version: 当前页面选择的api版本号。如: v3.0
    
    :api_lists: api文档列表,数组。 asbamboo\\api\\document\\ApiClassDoc[]
    
    :cur_api: 当前页面选择的api文档，asbamboo\\api\\document\\ApiClassDoc。未指定接口时返回null。

    :uris: 各个环境请求url。asbamboo\\api\\apiStore\\ApiRequestUrisInterface

    :cur_uri: 本次测试接口请求url，字符串。

    :test_name: 文档名称，字符串。

你可以只是自定义html渲染页面的路径

::

    <?php

    use asbamboo\di\Container;
    use asbamboo\http\ServerRequest;
    use asbamboo\api\document\Document;
    use asbamboo\api\view\Template;
    use asbamboo\api\apiStore\ApiStore;
    use asbamboo\api\Controller;

    $Container  = new Container();
    $Request    = new ServerRequest();
    $ApiStore   = new ApiStore('apistore_namespace', 'apistore_dir');

    $Template   = new Template(); 
    $Template->setPath('cuscom_template_dir');

    $Test       = new Test($Template);
    $Container->set('asbamboo\\api\\tool\\test\\TestInterface', $Test);

    $ApiController  = new Controller($ApiStore, $Request);
    $ApiController->setContainer($Container);

    ...

你也可以完全设置自定义的模板:

::

    <?php

    use asbamboo\di\Container;
    use asbamboo\http\ServerRequest;
    use asbamboo\api\document\Document;
    use asbamboo\api\apiStore\ApiStore;
    use asbamboo\api\Controller;

    $Container  = new Container();
    $Request    = new ServerRequest();
    $ApiStore   = new ApiStore('apistore_namespace', 'apistore_dir');
    $Template   = new CustomTemplate(); // 这个模板处理类自己定义
    $Test       = new Test($Template);
    $Container->set('asbamboo\\api\\tool\\test\\TestInterface', $Test);

    $ApiController  = new Controller($ApiStore, $Request);
    $ApiController->setContainer($Container);

    ...


.. _twig: https://twig.symfony.com/
.. _smarty: https://www.smarty.net/