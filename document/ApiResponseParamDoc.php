<?php
namespace asbamboo\api\document;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月28日
 */
class ApiResponseParamDoc implements ApiResponseParamDocInterface
{
    /**
     * 注释信息组成的数组
     *
     * @var array
     */
    private $docs;

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
     * 解析注释行
     *
     * @param string $api_class ApiClassInterface的一个类
     */
    private function parseDoc(\ReflectionProperty $ReflectionProperty) : void
    {
        $document   = $ReflectionProperty->getDocComment();

        if(preg_match_all('#@(\w+)(\s(.*))?[\r\n]#siU', $document, $matches)){
            foreach($matches[1] AS $index => $key){
                $value                = trim($matches[3][$index]);
                if(preg_match('@^eval:(.*)$@siU', $value, $match)){
                    $value    = eval('return ' . $match[1] . ';');
                }
                $value  = preg_replace([
                    '#\[\s*url\s*\]([^\[]*)\[\s*/url\s*\]#siU',
                    '#\[\s*url\s*:\s*([^\]]*)\s*\]([^\[]*)\[\s*/url\s*\]#siU',
                ], [
                    '<a href="$1">$1</a>',
                    '<a href="$1">$2</a>',
                ], $value);
                $this->docs[$key][]   = $value;
            }
        }
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