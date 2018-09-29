<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\InvalidTimestampException;

class Timestamp implements TimestampInterface
{
    /**
     *
     * @var ServerRequestInterface
     */
    private $Request;

    /**
     * timestamp 字段 在$_REQUEST变量中的键
     *
     * @var string
     */
    private $input_timestamp;

    /**
     * 有效时长
     *
     * @var int
     */
    private $lifetime;

    /**
     *
     * @param ServerRequestInterface $Request
     * @param string $input_timestamp
     * @param int $lifetime
     */
    public function __construct(ServerRequestInterface $Request, string $input_timestamp = 'timestamp', int $lifetime = 60 * 10)
    {
        $this->Request          = $Request;
        $this->input_timestamp  = $input_timestamp;
        $this->lifetime         = $lifetime;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\SignInterface::check()
     */
    final public function check() : bool
    {
        if(strtotime($this->getTimestamp()) > time() - $this->lifetime){
            throw new InvalidTimestampException('生成的请求参数已经超过有效期');
        }
        return true;
    }

    /**
     * 返回终端请求参数中的签名
     *
     * @return string
     */
    private function getTimestamp() : string
    {
        return $this->Request->getRequestParam($this->input_timestamp, '');
    }
}