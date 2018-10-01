<?php
namespace asbamboo\api;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
final class Event
{
    /**
     * api请求被controller接受，准备执行接口程序前触发这个事件
     *  - 可以通过监听这个事件，做一些判断，或者其他的事情。
     *  - 在event-listener有两个监听器，用于验证签名，或者请求是否在有效时间内
     *
     * @var string
     */
    const API_CONTROLLER    = 'api.controller';

    /**
     * 该事件在接口程序正式执行前触发
     *
     * @var string
     */
    const API_PRE_EXEC      = 'api.pre.exec';
}
