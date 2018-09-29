<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\InvalidSignException;

/**
 * 继承本来的api接口，在系统处理请求之前先做签名校验
 *  - 使用这个类的话，exec方法接收的$Params需要使用 trait (CommonApiRequestSignParamsTrait)
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
abstract class ApiClassBySign extends ApiClassAbstract
{
    /**
     *
     * @param SignInterface $Sign
     * @throws InvalidSignException
     */
    public function __construct(SignInterface $Sign)
    {
        if(!$Sign->check()){
            throw new InvalidSignException('无效的签名');
        }
        parent::__construct();
    }
}