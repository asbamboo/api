<?php
namespace asbamboo\api\_test\apiStore;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiResponseRedirectParams;
use asbamboo\http\RedirectResponse;
use asbamboo\http\TextResponse;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月13日
 */
class ApiResponseRedirectParamsTest extends TestCase
{
    public function testMakeRedirectResponseReturnRedirectResponse()
    {
        $Params = new TestReturnRedirectClass();
        $this->assertInstanceOf(RedirectResponse::class, $Params->makeRedirectResponse());
    }

    public function testMakeRedirectResponseReturnTextResponse()
    {
        $Params = new TestReturnTextClass();
        $this->assertInstanceOf(TextResponse::class, $Params->makeRedirectResponse());
    }
}

class TestReturnTextClass extends ApiResponseRedirectParams
{
    protected function getRedirectUri() : string
    {
        return 'http://test';
    }
    protected function getRedirectResponseData() : array
    {
        return [];
    }
}

class TestReturnRedirectClass extends ApiResponseRedirectParams
{
    protected function getRedirectType() : string
    {
        return 'get';
    }

    protected function getRedirectResponseData() : array
    {
        return ['test'=>'test'];
    }

    protected function getRedirectUri() : string
    {
        return 'http://test';
    }
}