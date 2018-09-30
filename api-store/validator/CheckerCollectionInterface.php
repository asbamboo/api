<?php
namespace asbamboo\api\apiStore\validator;

/**
 * 验证器集合
 *  - 可以像数组一样使用foreach循环
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
interface CheckerCollectionInterface extends \Iterator
{
    /**
     * 向集合中添加一个验证器
     *
     * @param CheckerInterface $Checker
     * @return CheckerCollectionInterface
     */
    public function add(CheckerInterface $Checker) : CheckerCollectionInterface;

    /**
     * 集合中移除一个验证器
     *
     * @param CheckerInterface $Checker
     * @return CheckerCollectionInterface
     */
    public function remove(CheckerInterface $Checker) : CheckerCollectionInterface;
}