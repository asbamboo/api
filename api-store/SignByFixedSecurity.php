<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ServerRequestInterface;

/**
 * 签名，使用固定不变的security
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月29日
 */
class SignByFixedSecurity extends SignAbstract
{
    /**
     * app security值，初始化后固定不变
     *
     * @var string
     */
    private $app_security;

    /**
     *
     * @param ServerRequestInterface $Request
     * @param string $input_app_key
     * @param string $input_sign
     * @param string $app_security
     */
    public function __construct(ServerRequestInterface $Request, string $input_app_key = 'app_key', string $input_sign = 'sign', string $app_security = 'security')
    {
        $this->app_security = $app_security;

        parent::__construct($Request, $input_app_key, $input_sign);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\SignAbstract::getAppSecurity()
     */
    protected function getAppSecurity() : string
    {
        return $this->app_security;
    }
}