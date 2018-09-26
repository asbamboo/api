<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\JsonResponse;
use asbamboo\api\exception\InvalidArgumentException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月26日
 */
abstract class ApiClassAbstract implements ApiClassInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiClassInterface::exec()
     */
    public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
    {
        if($Params->validate()){
            return $this->successApiResponseParams($Params);
        }else{
            return $this->invalidApiResponseParams($Params);
        }
    }

    /**
     * 成功时返回的响应参数
     *  - 如果有的话继承的类中重载本方法
     *
     * @return NULL
     */
    protected function successApiResponseParams()
    {
        return null;
    }

    /**
     * 没有通过参数验证时返回的响应参数
     *  - 如果有的话继承的类中重载本方法
     *
     * @throws InvalidArgumentException
     */
    protected function invalidApiResponseParams()
    {
        throw new InvalidArgumentException('无效的api请求参数。');
    }
}