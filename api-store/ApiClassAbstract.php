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
    protected $api_request_params_class;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiClassInterface::getApiRequestParamsClass()
     */
    public function getApiRequestParamsClass() : string
    {
        if(empty($this->api_request_params_class)){
            $this_class                     = get_class($this);
            $this->api_request_params_class = $this_class . '\\' . 'RequestParams';
        }
        return $this->api_request_params_class;
    }

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
     * @return NULL
     */
    protected function successApiResponseParams() : ?ApiResponseParamsInterface
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

    /**
     * 验证请求的参数是否合法
     *  - 通过验证应该返回 true
     *
     * @param ApiRequestParamsInterface $Params
     * @return bool
     */
    abstract public function validate(ApiRequestParamsInterface $Params) : bool;
}