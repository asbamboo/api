<?php
namespace asbamboo\api\apiStore;

/**
 * 响应参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class ApiResponseParams implements ApiResponseParamsInterface
{
    /**
     * 通过构造方法为属性赋值
     * 应该不允许属性修改
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach($data AS $param => $value){
            if(property_exists($this, $param)){
                $this->{$param} = $value;
            }
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseParamsInterface::getObjectVars()
     */
    public function getObjectVars() : ?array
    {
        return get_object_vars($this);
    }
}
