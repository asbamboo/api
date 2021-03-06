<?php
namespace asbamboo\api\document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
class ApiRequestParamDoc implements ApiRequestParamDocInterface
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
        $this->ReflectionProperty   = $ReflectionProperty;
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
     * 字段默认值
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->ReflectionProperty->getDeclaringClass()->getDefaultProperties()[$this->getName()];
    }

    /**
     * 在注释行未指定示例值的情况下，等于this::getDefaultValue();
     *  - 为了说明文档中展示正确的返回值，你应该配置示例值
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiRequestParamDocInterface::getExampleValue()
     */
    public function getExampleValue()
    {
        return isset($this->docs['example']) ? current($this->docs['example']) : $this->getDefaultValue();
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
     * 是否必须
     *  - "@required"
     *
     * @return string
     */
    public function getRequired() : string
    {
        return isset($this->docs['required']) ? implode("\r\n", $this->docs['required']) : '';
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

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\document\ApiRequestParamDocInterface::isCommon()
     */
    public function isCommon() : bool
    {
        return !empty($this->docs['common']);
    }
}