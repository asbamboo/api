<?php
namespace asbamboo\api\apiStore;

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
        $ApiResponseParams  = null;
        if($this->validate($Params)){
            $ApiResponseParams  = $this->successApiResponseParams($Params);
        }else{
            $ApiResponseParams  = $this->invalidApiResponseParams($Params);
        }
        return $ApiResponseParams;
    }

    /**
     * 成功时返回的响应参数
     *  - 如果有的话继承的类中重载本方法
     *
     * @param ApiRequestParamsInterface $Params
     * @return ApiResponseParamsInterface|NULL
     */
    protected function successApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
    {
        return null;
    }

    /**
     * 没有通过参数验证时返回的响应参数
     *  - 如果有的话继承的类中重载本方法
     *
     * @param ApiRequestParamsInterface $Params
     * @throws InvalidArgumentException
     * @return ApiResponseParamsInterface|NULL
     */
    protected function invalidApiResponseParams(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface
    {
        throw new InvalidArgumentException('无效的api请求参数。');
    }

    /**
     * 验证请求的参数是否合法
     *  - 通过验证应该返回 true
     *
     * @param ApiRequestParamsInterface $Params
     * @return bool
     */
    abstract public function validate(ApiRequestParamsInterface $Params) : bool;
}