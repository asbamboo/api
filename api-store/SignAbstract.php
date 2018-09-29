<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\InvalidSignException;

/**
 * 签名验证
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
abstract class SignAbstract implements SignInterface
{
    /**
     * 请求信息
     *
     * @var ServerRequestInterface
     */
    private $Request;

    /**
     * app key 字段在 $_REQUEST变量中的键
     *
     * @var string
     */
    private $input_app_key;

    /**
     * app sign 字段在 $_REQUEST变量中的键
     *
     * @var string
     */
    private $input_sign;

    /**
     *
     * @param ServerRequestInterface $Request
     * @param string $input_app_key
     * @param string $input_sign
     */
    public function __construct(ServerRequestInterface $Request, string $input_app_key = 'app_key', string $input_sign = 'sign')
    {
        $this->Request          = $Request;
        $this->input_app_key    = $input_app_key;
        $this->input_sign       = $input_sign;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\SignInterface::check()
     */
    final public function check() : bool
    {
        if($this->getRequestSign() != $this->getValidSign()){
            throw new InvalidSignException('无效的签名。');
        }
        return true;
    }

    /**
     * 返回终端请求参数中的签名
     *
     * @return string
     */
    private function getRequestSign() : string
    {
        return strtolower($this->Request->getRequestParam($this->input_sign, ''));
    }

    /**
     * 获取根据请求参数生成的有效的sign
     *
     * @return string
     */
    private function getValidSign() : string
    {
        $sign               = '';
        $request_params     = $this->Request->getRequestParams();
        ksort($request_params);
        foreach($request_params AS $request_key => $request_value){
            if($request_key == $this->input_app_key){
                continue;
            }
            $sign   = $request_key . $request_value;
        }
        return md5($sign);
    }

    /**
     *
     * @return string
     */
    abstract protected function getAppSecurity() : string;
}