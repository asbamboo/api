<?php
namespace asbamboo\api\apiStore;

/**
 * 是实现APiRequestUriInterface的类的集合
 * 如果不适用文档和api测试工具，可以不用实现这个类
 * 同一个APiRequestUriInterface::getType的实例只能添加到集合一次。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月2日
 */
interface ApiRequestUrisInterface extends \Iterator
{
    /**
     * 添加一个APiRequestUriInterface实例到集合
     * 同一个APiRequestUriInterface::getType的实例只能在集合里面存在一个。
     *
     * @param APiRequestUriInterface $APiRequestUri
     * @return APiRequestUrisInterface
     */
    public function add(APiRequestUriInterface $APiRequestUri) : APiRequestUrisInterface;

    /**
     * 返回指定类型的APiRequestUriInterface实例
     *
     * @param string $type
     * @return APiRequestUriInterface|NULL
     */
    public function get(string $type = APiRequestUriInterface::TYPE_DEV) : ?APiRequestUriInterface;
}