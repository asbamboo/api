<?php
namespace asbamboo\api\apiStore;

/**
 * api接口继承本类的话使用parant::validate可以验证签名
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
class ApiClassBySign extends ApiClassAbstract
{
    /**
     *
     * {@inheritDoc}
     * @param $Params 是ApiRequestParamsInterface的类，需要使用CommonApiRequestSignParamsTrait
     * @see \asbamboo\api\apiStore\ApiClassAbstract::validate()
     */
    public function validate(ApiRequestSignParamsInterface $Params): bool
    {
        $Params->getAppKey();
    }
}