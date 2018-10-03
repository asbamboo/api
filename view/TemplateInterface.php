<?php
namespace asbamboo\api\view;

/**
 * 模板控制器
 *  - 用于文档和测试工具配置的模板文件控制。
 *
 * 例如使用asbamboo\template渲染模板:
 *  <?php
 *  use asbamboo\template\TemplateInterface AS AsbambooTemplate;
 *
 *  class Template implements TemplateInterface
 *  {
 *      private $AsbambooTemplate;
 *
 *      private $path;
 *
 *      public function __construct(AsbambooTemplate $AsbambooTemplate)
 *      {
 *          $this->AsbambooTemplate   = $AsbambooTemplate;
 *      }
 *
 *      public function setPath(string $path) : TemplateInterface
 *      {
 *          $this->path = $path;
 *          return $this;
 *      }
 *
 *      public function getPath() : string
 *      {
 *          return $this->path;
 *      }
 *
 *      public function render(array $assign_data = []) : string
 *      {
 *          $this->AsbambooTemplate->render($this->getPath(), $assign_data);
 *      }
 *  }
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月3日
 */
interface TemplateInterface
{
    /**
     * 设置模板文件路径
     *
     * @param string $path
     * @return TemplateInterface
     */
    public function setPath(string $path) : TemplateInterface;

    /**
     * 返回模板文件路径
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * 渲染html页面
     * - 在渲染页面之前应该要设置模板文件路径
     *
     * @return string
     */
    public function render(array $assign_data = []) : string;
}
