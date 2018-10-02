<?php
namespace asbamboo\api\apiStore;

class ApiRequestUri implements ApiRequestUriInterface
{
    /**
     *
     * @var string
     */
    private $uri;

    /**
     *
     * @var string
     */
    private $desc;

    /**
     *
     * @var string
     */
    private $type;

    /**
     *
     * @param string ...$items
     */
    public function __construct(string ...$items)
    {
        @list($uri, $desc, $type) = $items;
        $this->uri      = $uri;
        $this->desc     = $desc;
        $this->type     = $type;
    }

    /**
     * 返回api接口请求的uri
     *
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri ?? '';
    }

    /**
     * 简要说明
     *
     * @return string
     */
    public function getDesc() : string
    {
        return $this->desc ?? '';
    }

    /**
     * 类型
     *  - 表示该uri应该适用于那个环境
     *  - develop 开发环境 test 测试环境 product 正式环境
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type ?? '';
    }
}