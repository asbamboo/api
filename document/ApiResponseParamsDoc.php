<?php
namespace asbamboo\api\document;
/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
class ApiResponseParamsDoc implements ApiResponseParamsDocInterface
{
    /**
     *
     * @var ApiResponseParamDocInterface[]
     */
    private $api_response_param_docs;

    /**
     *
     * @param string $api_response_params_class
     */
    public function __construct(string $api_response_params_class)
    {
        $this->parse($api_response_params_class);
    }

    /**
     * 解析api response params 类
     *
     * @param string $api_response_params_class
     */
    private function parse(string $api_response_params_class)
    {
        $Reflection = new \ReflectionClass($api_response_params_class);
        foreach($Reflection->getProperties() AS $Property){
            $this->api_response_param_docs[] = new ApiResponseParamDoc($Property);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->api_response_param_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::next()
     */
    public function next()
    {
        return next($this->api_response_param_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->api_response_param_docs);
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
        reset($this->api_response_param_docs);
    }
}