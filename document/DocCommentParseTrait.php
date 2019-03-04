<?php
namespace asbamboo\api\document;

trait DocCommentParseTrait
{

    /**
     * 注释信息组成的数组
     *
     * @var array
     */
    private $docs;


    /**
     * 解析注释行
     *  - 凡是一eval:开始的注释，表示后面时php表达式。
     *  - 如果注释中含有[url]http://httphost.com[/url]表示需要把这段注释解析成<a href="http://httphost.com">http://httphost.com</a>
     *  - 如果注释中含有[url:http://httphost.com]这个是链接[/url]表示需要把这段注释解析成<a href="http://httphost.com">这个是链接</a>
     *
     * @param string $Reflection Reflection Class or Reflection Property
     */
    private function parseDoc(\Reflector $Reflection) : void
    {
        $document   = $Reflection->getDocComment();

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
}