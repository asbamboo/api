<?php
namespace asbamboo\api\apiStore;

use asbamboo\api\exception\InvalidTimestampException;

/**
 * 继承本来的api接口，在系统处理请求之前先做请求参数有效时长验证
 *  - 使用这个类的话，exec方法接收的$Params需要使用 trait (CommonApiRequestTimestampParamsTrait)
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
abstract class ApiClassByTimestamp extends ApiClassAbstract
{
    /**
     *
     * @param TimestampInterface $Sign
     * @throws InvalidTimestampException
     */
    public function __construct(TimestampInterface $Timestamp)
    {
        if(!$Timestamp->check()){
            throw new InvalidTimestampException('生成的请求参数已经超过有效期');
        }
        parent::__construct();
    }
}