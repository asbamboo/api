<?php
namespace asbamboo\api\_test\apiStore\validator;

use PHPUnit\Framework\TestCase;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\TimestampChecker;
use asbamboo\api\exception\InvalidTimestampException;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\RequestParams;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiDelete;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class TimestampCheckerTest extends TestCase
{
    public function testCheckNotSetTimestamp()
    {
        $this->expectException(InvalidTimestampException::class);
        $org_request        = $_REQUEST;
        $_REQUEST           = [];
        $Request            = new ServerRequest();
        $TimestampChecker   = new TimestampChecker($Request);
        $TimestampChecker->check();
        $_REQUEST   = $org_request;
    }

    public function testCheckExpired()
    {
        $this->expectException(InvalidTimestampException::class);
        $org_request            = $_REQUEST;
        $_REQUEST               = [];
        $_REQUEST['timestamp']  = date('Y-m-d H:i:s', time() - 10 * 60 - 1);
        $Request                = new ServerRequest();
        $TimestampChecker       = new TimestampChecker($Request);
        $TimestampChecker->check();
        $_REQUEST   = $org_request;
    }

    public function testCheckOk()
    {
        $org_request            = $_REQUEST;
        $_REQUEST               = [];
        $_REQUEST['timestamp']  = date('Y-m-d H:i:s', time() - 10 * 60 + 1);
        $Request                = new ServerRequest();
        $TimestampChecker       = new TimestampChecker($Request);
        $this->assertTrue($TimestampChecker->check());
        $_REQUEST   = $org_request;
    }

    public function testIsSupport()
    {
        $Request                = new ServerRequest();
        $TimestampChecker       = new TimestampChecker($Request);
        $Api                    = new ApiFixed();
        $ApiRequestParams       = new RequestParams($Request);
        $this->assertFalse($TimestampChecker->isSupport($Api, $ApiRequestParams));

        $Api                    = new ApiDelete();
        $ApiRequestParams       = new \asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiDelete\RequestParams($Request);
        $this->assertTrue($TimestampChecker->isSupport($Api, $ApiRequestParams));
    }
}
