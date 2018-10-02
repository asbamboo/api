<?php
namespace asbamboo\api\apiStore\validator;

use asbamboo\http\ServerRequestInterface;
use asbamboo\api\exception\InvalidSignException;
use asbamboo\api\apiStore\ApiClassInterface;
use asbamboo\api\apiStore\ApiRequestParamsInterface;

/**
 * 签名验证
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
abstract class SignCheckerAbstract implements CheckerInterface
{
    /**
     * 请求信息
     *
     * @var ServerRequestInterface
     */
    protected $Request;

    /**
     * app key 字段在 $_REQUEST变量中的键
     *
     * @var string
     */
    protected $input_app_key;

    /**
     * app sign 字段在 $_REQUEST变量中的键
     *
     * @var string
     */
    protected $input_sign;

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
     * 在isSupport方法返回false的情况下，不应该调用check方法
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\validator\CheckerInterface::check()
     */
    final public function check() : bool
    {
        if($this->getRequestSign() != $this->getValidSign()){
            throw new InvalidSignException('无效的签名。');
        }
        return true;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\validator\CheckerInterface::isSupport()
     */
    public function isSupport(ApiClassInterface $ApiClass, ?ApiRequestParamsInterface $ApiRequestParams = null) : bool
    {
        return $ApiRequestParams && property_exists($ApiRequestParams, $this->input_sign);
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
        $request_params     = array_merge($this->Request->getPostParams()??[], $this->Request->getQueryParams()??[]);
        ksort($request_params);
        foreach($request_params AS $request_key => $request_value){
            if($request_key == $this->input_sign){
                continue;
            }
            $sign   .= $request_key . $request_value;
        }
        return md5($sign . $this->getAppSecurity());
    }

    /**
     *
     * @return string
     */
    abstract protected function getAppSecurity() : string;
}