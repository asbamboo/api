<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\InvalidSignException;
use asbamboo\api\exception\InvalidTimestampException;

/**
 * 继承本来的api接口，在系统处理请求之前先做签名校验和请求参数有效时长验证
 *  - 使用这个类的话，exec方法接收的$Params需要使用 trait (CommonApiRequestSignParamsTrait)
 *  - 使用这个类的话，exec方法接收的$Params需要使用 trait (CommonApiRequestTimestampParamsTrait)
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
    public function __construct(SignInterface $Sign, TimestampInterface $Timestamp)
    {
        if(!$Sign->check()){
            throw new InvalidSignException('无效的签名');
        }
        if(!$Timestamp->check()){
            throw new InvalidTimestampException('生成的请求参数已经超过有效期');
        }
        parent::__construct();
    }
}