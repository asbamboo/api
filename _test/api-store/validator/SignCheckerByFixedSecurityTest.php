<?php
namespace asbamboo\api\_test\apiStore\validator;

use PHPUnit\Framework\TestCase;
use asbamboo\api\exception\InvalidSignException;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiDelete\RequestParams;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiDelete;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月3日
 */
class SignCheckerByFixedSecurityTest extends TestCase
{
    public $org_request;
    public $org_post;

    public function setUp()
    {
        $this->org_request    = $_REQUEST;
        $this->org_post       = $_POST;
    }

    public function tearDown()
    {
        $_REQUEST   = $this->org_request;
        $_POST      = $this->org_post;
    }

    public function testCheckNotSign()
    {
        $this->expectException(InvalidSignException::class);
        $org_request        = $_REQUEST;
        $_REQUEST           = [];
        $Request            = new ServerRequest();
        $SignChecker        = new SignCheckerByFixedSecurity($Request);
        $SignChecker->check();
        $_REQUEST   = $org_request;
    }

    public function testCheckInvalid()
    {
        $this->expectException(InvalidSignException::class);
        $org_request            = $_REQUEST;
        $_REQUEST               = [];
        $_REQUEST['p1']         = 'p1';
        $_REQUEST['p2']         = 'p2';
        $_REQUEST['timestamp']  = date('Y-m-d H:i:s');
        $_REQUEST['sign']       = 'invalid sign.';
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $SignChecker->check();
        $_REQUEST   = $org_request;
    }

    public function testCheckOk()
    {
        $org_post               = $_POST;
        $_POST                  = [];
        $_POST['p2']            = 'p2';
        $_POST['p1']            = 'p1';
        $_POST['timestamp']     = date('Y-m-d H:i:s');
        ksort($_POST);
        $sign_data              = $_POST;
        $sign_str               = '';
        foreach($sign_data AS $k => $v){
            $sign_str .= $k . $v;
        }
        $_POST['sign']          = md5( $sign_str . 'security');
        $_REQUEST               = $_POST;
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $this->assertTrue($SignChecker->check());
        $_POST   = $org_post;
    }

    public function testIsSupport()
    {
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $Api                    = new ApiDelete();
        $ApiRequestParams       = new RequestParams($Request);
        $this->assertTrue($SignChecker->isSupport($Api, $ApiRequestParams));

        $Api                    = new ApiFixed();
        $ApiRequestParams       = new \asbamboo\api\_test\fixtures\apiStore\v1_0_0\apiFixed\RequestParams($Request);
        $this->assertFalse($SignChecker->isSupport($Api, $ApiRequestParams));
    }
}