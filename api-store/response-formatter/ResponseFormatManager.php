<?php
namespace asbamboo\api\apiStore\responseFormatter;

use asbamboo\api\exception\NotSupportedFormatException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
class ResponseFormatManager implements ResponseFormatManagerInterface
{
    /**
     * 该数组的value有时候是ResponseFormatterInterface实现类的类名，有时候是ResponseFormatterInterface实现类的实例
     *
     * - ["name1" => "class1", "name2" => "class2"]
     * - ["name1" => ResponseFormatterObject1, "name2" => ResponseFormatterObject2]
     * - ["name1" => "class1", "name2" => ResponseFormatterObject2]
     *
     * @var array
     */
    private $handlers;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface::appendHandler()
     */
    public function appendHandler(string $format_name, string $formatter_class) : ResponseFormatManagerInterface
    {
        $this->handlers[$format_name] = $formatter_class;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface::removeHandler()
     */
    public function removeHandler(string $format_name) : ResponseFormatManagerInterface
    {
        unset($this->handlers[$format_name]);
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface::hasHandler()
     */
    public function hasHandler(String $format_name) : bool
    {
        return isset($this->handlers[$format_name]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\responseFormatter\ResponseFormatManagerInterface::getHandler()
     */
    public function getHandler(string $format_name) : ResponseFormatterInterface
    {
        if(!$this->hasHandler($format_name)){
            throw new NotSupportedFormatException("不支持{$format_name}格式");
        }

        $ResponseFormatter  = $this->handlers[$format_name];
        if(is_string($ResponseFormatter)){
            $this->handlers[$format_name]   = new $ResponseFormatter();
        }

        return $this->handlers[$format_name];
    }
}