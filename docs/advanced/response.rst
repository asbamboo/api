asbamboo/api 进阶（自定义响应值）
=======================================

#. 响应值元信息类_
#. 响应值格式化管理器_
#. 响应值生成_

默认情况下 asbamboo\\api\\Controller 使用 asbamboo\\api\\apiStore\\ApiResponse 类构造api接口的响应值。你可以自己重写一个实现 asbamboo\\api\\apiStore\\ApiResponseInterface 的类，但应该用不着这样做。

asbamboo\\api\\apiStore\\ApiResponse 通过响应值元信息构造类，和响应值格式化管理器两个终于的部分控制响应值内容。

响应值元信息类
--------------------------

asbamboo\\api\\apiStore\\ApiResponse实例，默认的响应值元信息类是 asbamboo\\api\\apiStore\\ApiResponseMetadata，他的属性表示返回的响应值的字段列表。

:code: 状态码
:message: 与状态码对应的字符串描述
:data: 响应数据列表, 数组格式序列化的 `asbamboo\\api\\apiStore\\ApiResponseParamsInterface`_

你可以在实例化 asbamboo\\api\\apiStore\\ApiResponse 通过构造方法的参数，自定义响应值元信息类。

自定义元信息类示例(将code字段改成status):

::

    <?php
    class CustomApiResponseMetadata implements ApiResponseMetadataInterface
    {
        /**
         *
         * @var string
         * @desc 状态码。成功时返回'success'。
         */
        protected $status;
    
        /**
         * @desc 状态说明。成功时是"success", 错误时返回与code对应的错误信息
         * @var string
         */
        protected $message;
    
        /**
         * @desc 响应数据信息 见响应信息data具体字段
         * @var data
         */
        protected $data;
    
        public function setCode($code) : ApiResponseMetadataInterface
        {
            if($code === "0"){
                $this->status   = 'success';
            }else{
                ...
            }
            return $this;
        }
    
        public function getCode() : string
        {
            return (string) $this->status;
        }
    
        public function setMessage(string $message) : ApiResponseMetadataInterface
        {
            $this->message  = $message;
            return $this;
        }
    
        public function getMessage() : string
        {
            return $this->message;
        }
    
        public function setData(?ApiResponseParamsInterface $ApiResponseParams) : ApiResponseMetadataInterface
        {
            $this->data = $ApiResponseParams;
            return $this;
        }
    
        public function getData() : ?ApiResponseParamsInterface
        {
            return $this->data;
        }
    }


使用自定义的响应值元信息类:

::

    <?php

    use asbamboo\\api\\apiStore\\ApiResponse;

    $ApiResponseMetadata    = new CustomApiResponseMetadata();
    $ApiResponse            = new ApiResponse($ApiResponseMetadata);

    ...
    

响应值格式化管理器
--------------------------

响应值格式化管理器(asbamboo\\api\\apiStore\\responseFormatter\\ResponseFormatManagerInterface)，默认的是asbamboo\\api\\apiStore\\responseFormatter\\ResponseFormatManager。

* public function appendHandler(string $format_name, string $formatter_class) : ResponseFormatManagerInterface;

    追加一个响应值格式化处理器

    :$format_name: 格式化处理器名称
    :$formatter_class: 格式化处理器类名

* public function removeHandler(string $format_name) : ResponseFormatManagerInterface;

    剔除一个响应值格式化处理器 $format_name

* public function hasHandler(String $format_name) : bool;

    判断是否含有响应值格式化处理器 $format_name

* public function getHandler(string $format_name) : ResponseFormatterInterface;

    返回响应值格式化处理器 $format_name

返回响应值格式化处理器的asbamboo\\api\\apiStore\\responseFormatter\\ResponseFormatterInterface，目前在asbamboo/api中 只有一个json格式处理类 asbamboo\\api\\apiStore\\responseFormatter\\JsonResponseFormatter。如果你需要其他格式比如xml，那你需要自己去实现它，只需要实现handle方法。

* public function handle(ApiResponseMetadataInterface $ApiResponseMetadata) : ResponseInterface;

    这个方法接收一个响应值元信息，应该返回一个 asbamboo\\http\\ResponseInterface 实例。[`asbamboo/http`_]

需要自定义响应值格式化管理器的，通过 asbamboo\\api\\apiStore\\ApiResponse::setResponseFormatManager 实现：

::

    <?php

    use asbamboo\api\apiStore\ApiResponse;
    use asbamboo\api\apiStore\responseFormatter\ResponseFormatManager;

    $ApiResponseMetadata    = new CustomApiResponseMetadata();
    $ResponseFormatManager  = new ResponseFormatManager();
    $ApiResponse            = new ApiResponse($ApiResponseMetadata);

    $ResponseFormatManager->appendHandler('json', 'asbamboo\api\apiStore\responseFormatter\JsonResponseFormatter');

    $ApiResponse->setResponseFormatManager($ResponseFormatManager);

    ...

响应值生成
----------------------

Api接口逻辑的处理(asbamboo\\api\\Controller::api)方法，调用asbamboo\\api\\apiStore\\ApiResponse::makeResponse方法生成响应值。

makeResponse 方法负责从响应值格式化管理器中找到合适的响应值格式化处理器，生成响应值。


.. _asbamboo\\api\\apiStore\\ApiResponseParamsInterface: ../how_to_create_api/response_params.rst
.. _asbamboo/http: http://github.com/asbamboo/http

