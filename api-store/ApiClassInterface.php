<?php
namespace asbamboo\api\apiStore;

/**
 * api接口处理类接口。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月24日
 */
interface ApiClassInterface
{
    /**
     * 返回该接口实现ApiRequestParamsInterface的class文件
     *  - 该class的实例用于ApiClassInterface::exec方法的参数
     *
     * @return string
     */
    public function getApiRequestParamsClass() : string;

   /**
     * 执行api请求
     *  - 参数 ApiRequestParamsInterface 应该是 ApiClassInterface::getApiRequestParamsClass() 生成的实例
     *  - 返回值 ApiResponseParamsInterface 用于生成响应信息（ApiResponseInterface）
     *
     * @param ApiRequestParamsInterface $Params
     * @return ApiResponseParamsInterface|NULL
     */
    public function exec(ApiRequestParamsInterface $Params) : ?ApiResponseParamsInterface;
}