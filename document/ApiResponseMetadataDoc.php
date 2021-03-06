<?php
namespace asbamboo\api\document;

/**
 * api接口响应元信息的帮助信息
 *  - 一个响应元信息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月26日
 */
class  ApiResponseMetadataDoc implements ApiResponseMetadataDocInterface
{
    use DocCommentParseTrait;

    /**
     *
     * @var \ReflectionProperty
     */
    private $ReflectionProperty;

    /**
     *
     * @param \ReflectionProperty $ReflectionProperty
     */
    public function __construct(\ReflectionProperty $ReflectionProperty)
    {
        $this->ReflectionProperty = $ReflectionProperty;
        $this->parseDoc($ReflectionProperty);
    }

    /**
     * 字段名称
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->ReflectionProperty->getName();
    }

    /**
     * 如果示例值没有的话，默认等于空字符串。
     *  - 为了说明文档中展示正确的返回值，你应该配置示例值
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiRequestParamDocInterface::getExampleValue()
     */
    public function getExampleValue()
    {
        return isset($this->docs['example']) ? current($this->docs['example']) : '';
    }

    /**
     * 字段类型
     *  - "@var"
     *
     * @return string
     */
    public function getVar() : string
    {
        return isset($this->docs['var']) ? implode("\r\n", $this->docs['var']) : '';
    }

    /**
     * 取值范围
     *  - "@range"
     *
     * @return string
     */
    public function getRange() : string
    {
        return isset($this->docs['range']) ? implode("\r\n", $this->docs['range']) : '';
    }

    /**
     * 描述
     *  - "@desc"
     *
     * @return string
     */
    public function getDesc() : string
    {
        return isset($this->docs['desc']) ? implode("\r\n", $this->docs['desc']) : '';
    }
}