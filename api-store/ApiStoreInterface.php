<?php
namespace asbamboo\api\apiStore;

/**
 * api 仓库接口
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月12日
 */
interface ApiStoreInterface
{
    /**
     * 获取api仓库的命名空间
     * 需要与getDir对应
     *
     * @return string
     */
    public function getNamespace() : string;

    /**
     * 获取api仓库的文件目录
     * 需要与变量getNamespace对应
     *
     * @return string
     */
    public function getDir() : string;

    /**
     * 查找某个版本的api应该被使用class处理
     *
     * @param string $version
     * @param string $path
     * @return string
     */
    public function findApiClass(string $version, string $path) : string;

    /**
     * 返回所有的api版本列表
     *
     * @param int $sort_type 0:按照版本号升序排列，1:按照版本号降序排列。
     * @return array
     */
    public function findApiVersions(int $sort_type = 0) : array;
}