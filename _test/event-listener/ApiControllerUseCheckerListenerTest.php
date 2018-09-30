<?php
namespace asbamboo\api\_test\apiStore\eventListener;

use PHPUnit\Framework\TestCase;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;
use asbamboo\api\apiStore\validator\TimestampChecker;
use asbamboo\api\apiStore\validator\CheckerCollection;
use asbamboo\api\eventListener\ApiControllerUseCheckerListener;
use asbamboo\api\exception\ApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class ApiControllerUseCheckerListenerTest extends TestCase
{
    /**
     *
     */
    public function testOnCheckFailed()
    {
        $this->expectException(ApiException::class);
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $TimestampChecker       = new TimestampChecker($Request);
        $CheckerCollection      = new CheckerCollection([$SignChecker, $TimestampChecker]);
        $Listener               = new ApiControllerUseCheckerListener($CheckerCollection);
        $Listener->onCheck();
        $this->assertTrue(true);
    }

    public function testOnCheckOk()
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
        $TimestampChecker       = new TimestampChecker($Request);
        $CheckerCollection      = new CheckerCollection([$SignChecker, $TimestampChecker]);
        $Listener               = new ApiControllerUseCheckerListener($CheckerCollection);
        $Listener->onCheck();
        $this->assertTrue(true);

        $_REQUEST   = $org_request;

    }
}
