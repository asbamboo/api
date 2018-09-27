<?php
namespace asbamboo\api\document;

use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiStoreInterface;

/**
 * 文档生成器
 *  - 根据获取的api仓库中api类的注释信息解析生成文档。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface DocumentInterface
{
    /**
     * 获取Api版本库信息
     *
     * @return ApiStoreInterface
     */
    public function getApiStore() : ApiStoreInterface;

    /**
     * 版本列表数组
     *
     * @return array
     */
    public function versionListArray() : array;

    /**
     * API接口列表数组
     *
     * @param string $version
     * @return ApiClassDocInterface[] 数组的可以是ApiClassDocInterface::getPath()
     */
    public function apiListArray(string $version) : array;

    /**
     * API接口详情
     *
     * @param string $version
     * @param string $path
     * @return ApiClassDocInterface
     */
    public function apiDetailInfo(string $version, string $path) : ApiClassDocInterface;

    /**
     * API接口详情响应
     *
     * @param string $version
     * @param string $path
     * @return ResponseInterface
     */
    public function response(string $version = '', string $path = '') : ResponseInterface;
}