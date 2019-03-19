asbamboo/api 接口编写(创建api仓库)
=====================================

api仓库是指存放在文件系统中，专门用来处理api接口逻辑处理程序脚本的文件夹。

api仓库的规则:

    * api仓库下第一级目录表示接口的版本号

    * 版本号应该以字母v开头，后面跟随数字版本号，并将小数点(".")替换为下划线("_")。(为了符合php的命名空间规则的语法)

    * `在版本目录下添加接口逻辑处理程序`_

         接口处理程序类的命名规则时在 `psr4`_ 命名规则的基础上，文件夹的驼峰式命名修改为(使用链接符号"-"命名)。每个单词的首字母大写。
         
         接口的名称规则是将接口的路径中符号("/")替换为符号(".")，单词的首字母换成小写。
         
    * 当api版本升级时，如果某个api接口逻辑处理程序，未做修改。那么不必在新的版本库中创建它。

        当一个api接口逻辑处理程序在当前版本不存在时，asbamboo/api 工作的方式是在api仓库中查找该api接口逻辑处理程序最后的版本。

    * 当api版本升级时，如果某个api接口逻辑处理程序，被删除了。那么在新的版本库中需要声明它被删除了。
        

如图所示, api/store 目录为一个api仓库:

 .. image:: ../images/api_store.png

 v1.0版本有两个接口
    
 :post.detail: api/store/v1_0/post/Detail.php
 :post.lists: api/store/v1_0/post/Lists.php

 v2.0版本有四个接口
    
 :post.detail: api/store/v1_0/post/Detail.php
 :post.lists: api/store/v1_0/post/Lists.php
 :post.create: api/store/v2_0/post/Create.php
 :post.update: api/store/v2_0/post/Update.php
    
api仓库, 使用asbamboo\\api\\apiStore\\ApiStore 类声明:

::

    <?php
    
    use asbamboo\\api\\apiStore\\ApiStore;

    ...
    
    /**
     * $namespace api仓库的根namespace
     * $dir api仓库的根目录
     * - 命名空间遵守psr4规则（https://www.php-fig.org/psr/psr-4/）
     */
    $ApiStore   = new ApiStore($namespace, $dir);


.. _在版本目录下添加接口逻辑处理程序: api_class.rst
.. _psr4: https://www.php-fig.org/psr/psr-4/