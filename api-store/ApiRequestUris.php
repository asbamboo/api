<?php
namespace asbamboo\api\apiStore;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
class ApiRequestUris implements ApiRequestUrisInterface
{
    /**
     *
     * @var ApiRequestUriInterface[]
     */
    private $api_request_uris   = [];

    /**
     *
     * @param ApiRequestUriInterface ...$api_request_uris
     */
    public function __construct(ApiRequestUriInterface ...$api_request_uris)
    {
        foreach($api_request_uris AS $ApiRequestUri){
            $this->add($ApiRequestUri);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiRequestUrisInterface::add()
     */
    public function add(ApiRequestUriInterface $APiRequestUri) : ApiRequestUrisInterface
    {
        $type                           = $APiRequestUri->getType();
        $this->api_request_uris[$type]  = $APiRequestUri;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiRequestUrisInterface::get()
     */
    public function get(string $type = ApiRequestUriInterface::TYPE_DEV) : ?ApiRequestUriInterface
    {
        if(isset($this->api_request_uris[$type])){
            return $this->api_request_uris[$type];
        }
        return null;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->api_request_uris);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::next()
     */
    public function next()
    {
        return next($this->api_request_uris);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->api_request_uris);
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
        reset($this->api_request_uris);
    }
}