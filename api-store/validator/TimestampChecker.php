<?php
namespace asbamboo\api\apiStore\validator;

use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\InvalidTimestampException;

/**
 * 请求参数是否在有效时间内验证
 *  - 默认timestamp的值必须时服务器时间的10分钟内，才有效
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class TimestampChecker implements CheckerInterface
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
     * @see \asbamboo\api\apiStore\validator\CheckerInterface::check()
     */
    final public function check() : bool
    {
        if(strtotime($this->getTimestamp()) < time() - $this->lifetime){
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