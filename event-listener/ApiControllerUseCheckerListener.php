<?php
namespace asbamboo\api\eventListener;

use asbamboo\api\apiStore\validator\CheckerCollectionInterface;
use asbamboo\api\exception\ApiException;

/**
 * 监听器. 蒋婷api.controller事件，做一些验证处理。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class ApiControllerUseCheckerListener
{
    /**
     *
     * @var CheckerCollectionInterface
     */
    private $CheckerCollection;

    /**
     *
     * @param CheckerCollectionInterface $CheckerCollection
     */
    public function __construct(CheckerCollectionInterface $CheckerCollection)
    {
        $this->CheckerCollection  = $CheckerCollection;
    }

    /**
     * 执行验证器
     *
     * @throws ApiException
     */
    public function onCheck()
    {
        /**
         * @var asbamboo\api\apiStore\validator\CheckerInterface $Checker
         */
        foreach($this->CheckerCollection AS $Checker){
            if($Checker->check() == false){
                throw new ApiException('没有满足所有执行接口程序的前置条件。');
            }
        }
    }
}
