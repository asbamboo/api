<?php
namespace asbamboo\api\view;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月3日
 */
class Template implements TemplateInterface
{
    /**
     * 模板的路径
     *
     * @var string
     */
    private $path;

    /**
     * 设置模板文件路径
     *
     * @param string $path
     * @return TemplateInterface|NULL
     */
    public function setPath(string $path) : TemplateInterface
    {
        $this->path = $path;
        return $this;
    }

    /**
     * 返回模板文件路径
     *
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * 渲染html页面
     * - 在渲染页面之前应该要设置模板文件路径
     *
     * @return string
     */
    public function render(array $assign_data = []) : string
    {
        extract($assign_data);

        ob_start();
        include $this->getPath();
        $content    = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
