<?php
namespace asbamboo\api\document;

/**
 * api接口请求参数的帮助信息
 *  - 请求参数集合
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月27日
 */
class ApiRequestParamsDoc implements ApiRequestParamsDocInterface
{
    /**
     *
     * @var ApiRequestParamDocInterface[]
     */
    private $api_request_param_docs;

    /**
     *
     * @param string $api_request_params_class
     */
    public function __construct(string $api_request_params_class)
    {
        $this->parse($api_request_params_class);
    }

    /**
     * 解析api request params 类
     *
     * @param string $api_request_params_class
     */
    private function parse(string $api_request_params_class)
    {
        $Reflection = new \ReflectionClass($api_request_params_class);
        foreach($Reflection->getProperties() AS $Property){
            $this->api_request_param_docs[] = new ApiRequestParamDoc($Property);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->api_request_param_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::next()
     */
    public function next()
    {
        return next($this->api_request_param_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->api_request_param_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::valid()
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::rewind()
     */
    public function rewind()
    {
        reset($this->api_request_param_docs);
    }
}