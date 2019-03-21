asbamboo/api 接口编写(创建api接口逻辑处理类)
======================================================

api接口逻辑处理类是一个api接口的逻辑处理程序。

接口名称与接口版本
-------------------------------

请求一个API接口时，如果请求的版本库中找不到对应的接口，那么 asbamboo/api 程序会逐级在更低版本号的版本库中查找相同的接口，找到为止。`见api仓库中的图片说明`_

api名称接受两种格式：

* 相对路径格式：

    接口的名称是api接口逻辑处理类在api仓库的版本库目录下，所处的相对文件路径。特别的是驼峰试类名需要改成连字符（"-"）试。

    如asbamboo\api\_test\fixtures\apiStore\v2_0_0\ApiNew 类的接口名称为 /api-new

* 符号转义格式

    接口的名称是api接口逻辑处理类在api仓库的版本库目录下，所处的相对文件路径做规则转义:
    
        * 符号斜杠("/")转换为符号点(".")
        * 单词首字母小写。（以符号(".")与符号("-")分隔，第一个字母小写。）
        * 删除符号"-"
    
如{api仓库}/{v版本号}/post/Detail.php的接口名称是：/post/detail(相对路径格式) 或者 post.detail（符号转义格式）

asbamboo\\api\\_test\\apiStore\\ApiStoreTest\\testFindApiClass是查找接口的一个单元测试。

api接口逻辑处理类
-----------------------------------------------------------------------------

每一个api接口逻辑处理类都应该实现asbamboo\\api\\apiStore\\ApiClassInterface，必须完成其中的exec方法。

* public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface;

    exec 方法用于处理接口程序的逻辑:

    * $Params `接口接收到的参数`_

        应该在接口类所在目录下，建立一个与接口名相同的文件夹，在该文件夹下创建RequestParams类（或者在接口类的注释块中使用@request注释声明RequestParams类的名称）

        RequestParams类实现asbamboo\\api\\apiStore\\ApiRequestParamsInterface

        RequestParams类用来声明该接口接受的请求参数列表。

    * `接口返回的响应值`_

        应该在接口类所在目录下，建立一个与接口名相同的文件夹，在该文件夹下创建ResponseParams类（或者在接口类的注释块中使用@response注释声明ResponseParams类的名称）

        ResponseParams类实现asbamboo\\api\\apiStore\\ApiResponseParamsInterface

        ResponseParams类用来声明接口响应的参数列表。
        
示例(代码选自 `asbamboo/openpay`_ 的接口 trade.query):

::

    <?php
    namespace asbamboo\openpay\apiStore\handler\v1_0\trade;
    
    use asbamboo\openpay\channel\ChannelManagerInterface;
    use asbamboo\api\apiStore\ApiRequestParamsInterface;
    use asbamboo\api\apiStore\ApiResponseParamsInterface;
    use asbamboo\openpay\model\tradePay\TradePayRepository;
    use asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryRequest;
    use asbamboo\api\apiStore\ApiClassInterface;
    use asbamboo\openpay\apiStore\exception\TradeQueryNotFoundInvalidException;
    use asbamboo\openpay\Constant;
    use asbamboo\openpay\channel\v1_0\trade\queryParameter\Request AS RequestByChannel;
    use asbamboo\openpay\model\tradePay\TradePayManager;
    use asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryResponse;
    use asbamboo\database\FactoryInterface;
    use asbamboo\openpay\model\tradePayClob\TradePayClobRepository;
    
    /**
     * @name 交易查询
     * @desc 交易查询
     * @request asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryRequest
     * @response asbamboo\openpay\apiStore\parameter\v1_0\trade\query\QueryResponse
     * @author 李春寅<licy2013@aliyun.com>
     * @since 2018年10月27日
     */
    class Query implements ApiClassInterface
    {
        ...
    
        /**
         *
         * @param ChannelManagerInterface $Client
         */
        public function __construct(ChannelManagerInterface $ChannelManager, FactoryInterface $Db, TradePayRepository $TradePayRepository, TradePayClobRepository $TradePayClobRepository, TradePayManager $TradePayManager)
        {
            $this->ChannelManager           = $ChannelManager;
            $this->TradePayRepository       = $TradePayRepository;
            $this->TradePayManager          = $TradePayManager;
            $this->TradePayClobRepository   = $TradePayClobRepository;
            $this->Db                       = $Db;
        }
    
        /**
         *
         * {@inheritDoc}
         * @see \asbamboo\api\apiStore\ApiClassAbstract::exec()
         * @var QueryRequest $Params
         */
        public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
        {
            $TradePayEntity     = null;
            $TradePayClobEntity = null;
            if(strlen((string)$Params->getInTradeNo()) > 0){
                $TradePayEntity     = $this->TradePayRepository->load($Params->getInTradeNo());
            }elseif(strlen((string)$Params->getOutTradeNo()) > 0){
                $TradePayEntity = $this->TradePayRepository->loadByOutTradeNo($Params->getOutTradeNo());
            }
            if(empty($TradePayEntity)){
                throw new TradeQueryNotFoundInvalidException('没有找到交易记录,请确认 in_trade_no 或 out_trade_no 参数.');
            }
            
            ...
    
            return new QueryResponse([
    
            ...
            
            ]);
        }
    }

接口处理类class的注释信息会被用来生成在线文档。
-----------------------------------------------------------------

在上面的class例子中，class的注释块时有特殊用途的，注释将用来自动 `生成在线文档`_。

:@name: 接口名称（非接口请求时的名字，是文档说明中描述接口用途的接口名称）
:@desc: 接口说明描述描述
:@uris: 接口请求的url *请见* `在线文档生成`_
:@request: `指定接口参数映射类`_
:@response: `指定接口响应值映射类`_
:@delete: 如果该接口应该已经被删除的话需要在注释说明（* @delete true）


使用asbamboo\\api\\apiStore\\Abstract\\ApiClassAbstract类
-------------------------------------------------------------

asbamboo/api 内部还提供了一个实现 asbamboo\\api\\apiStore\\ApiClassInterface的抽象类 asbamboo\\api\\apiStore\\Abstract\\ApiClassAbstract。

抽象类中exec调用中，分别调用如下三个方法, 返回得到的 `响应值映射对象`_ :

*   abstract public function validate(ApiRequestParamsInterface $Params) : bool;

    继承这个抽象类的接口类，必须实验这个方法，用来验证请求的参数。如果参数输入有效，该方法应该返回true。

*   protected function successApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface

    当请求参数通过验证时执行这个方法。
    
    继承这个抽象类的接口类，可以复写这个方法处理程序业务逻辑。
    
    默认返回值null，表示没有指定响应参数。

*   protected function invalidApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface

    当请求参数未通过验证时执行这个方法。

    继承这个抽象类的接口类，可以复写这个方法处理参数未通过验证时候的程序业务逻辑。

    默认抛出异常 asbamboo\\api\\exception\\InvalidArgumentException，表示参数无效。

示例(代码选自 `asbamboo/framework-demo`_ 的接口 post.detail):

::

    <?php
    namespace asbamboo\frameworkDemo\api\store\v1_0\post;
    
    use asbamboo\api\apiStore\ApiClassAbstract;

    ...
    
    /**
     *
     * @name 文章详情
     * @desc 获取指定序号的文章详情
     * @author 李春寅 <licy2013@aliyun.com>
     * @since 2018年9月30日
     */
    class Detail extends ApiClassAbstract
    {
        ...
        
        /**
         *
         * {@inheritDoc}
         * @see \asbamboo\api\apiStore\ApiClassAbstract::validate()
         */
        public function validate(ApiRequestParamsInterface $Params) : bool
        {
            /**
             *
             * @var UserEntity $User
             * @var RequestParams $Params
             */
            $post_seq       = $Params->getPostSeq();
    
            if(empty($post_seq)){
                throw new InvalidPostSeqException('参数文章序号无效');
            }
            
            ...
    
            return true;
        }
    
        /**
         *
         * {@inheritDoc}
         * @see \asbamboo\api\apiStore\ApiClassAbstract::successApiResponseParams()
         */
        public function successApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
        {
            return new ResponseParams([
                ...
            ]);
        }
    }


.. _见api仓库中的图片说明: api_store.rst
.. _接口接收到的参数: request_params.rst
.. _指定接口参数映射类: 接口接收到的参数_
.. _接口返回的响应值: response_params.rst
.. _指定接口响应值映射类: 接口返回的响应值_
.. _响应值映射对象: 接口返回的响应值_
.. _在线文档生成: comments_to_document.rst
.. _生成在线文档: 在线文档生成_
.. _asbamboo/openpay: http://github.com/asbamboo/openpay
.. _asbamboo/framework-demo: http://github.com/asbamboo/framework-demo
