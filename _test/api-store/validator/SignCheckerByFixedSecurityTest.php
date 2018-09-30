<?php
namespace asbamboo\api\_test\apiStore\validator;

use PHPUnit\Framework\TestCase;
use asbamboo\api\exception\InvalidSignException;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;

class SignCheckerByFixedSecurityTest extends TestCase
{

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
        $org_request            = $_REQUEST;
        $_REQUEST               = [];
        $_REQUEST['p2']         = 'p2';
        $_REQUEST['p1']         = 'p1';
        $_REQUEST['timestamp']  = date('Y-m-d H:i:s');
        ksort($_REQUEST);
        $sign_data              = $_REQUEST;
        $sign_str               = '';
        foreach($sign_data AS $k => $v){
            $sign_str .= $k . $v;
        }
        $_REQUEST['sign']       = md5( $sign_str . 'security');
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $this->assertTrue($SignChecker->check());
        $_REQUEST   = $org_request;
    }

}