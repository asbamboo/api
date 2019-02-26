<?php
namespace asbamboo\api\document;
/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
class ApiResponseMetadatasDoc implements ApiResponseMetadatasDocInterface
{
    /**
     *
     * @var ApiResponseMetadataDocInterface[]
     */
    private $api_response_metadata_docs;

    /**
     *
     * @var string
     */
    private $api_response_metadata_class;

    /**
     *
     * @param string $api_response_metadata_class
     */
    public function __construct(string $api_response_metadata_class)
    {
        $this->parse($api_response_metadata_class);
    }

    /**
     * 解析api response params 类
     *
     * @param string $api_response_metadata_class
     */
    private function parse(string $api_response_metadata_class)
    {
        $this->api_response_metadata_class    = $api_response_metadata_class;
        $Reflection                         = new \ReflectionClass($api_response_metadata_class);
        foreach($Reflection->getProperties() AS $Property){
            $this->api_response_metadata_docs[$Property->getName()] = new ApiResponseMetadataDoc($Property);
        }
        ksort($this->api_response_metadata_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiResponseParamsDocInterface::getClass()
     */
    public function getClass() : string
    {
        return $this->api_response_metadata_class;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->api_response_metadata_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::next()
     */
    public function next()
    {
        return next($this->api_response_metadata_docs);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->api_response_metadata_docs);
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
        reset($this->api_response_metadata_docs);
    }
}