<?php
namespace asbamboo\api\_test\apiStore\validator;

use PHPUnit\Framework\TestCase;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\TimestampChecker;
use asbamboo\api\exception\InvalidTimestampException;

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
}
