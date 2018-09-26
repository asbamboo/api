<?php
namespace asbamboo\api\_test\apiStore;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiStore;
use asbamboo\api\exception\NotSupportedFormatException;
use asbamboo\http\JsonResponse;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiDelete;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiUpdate;
use asbamboo\api\_test\fixtures\apiStore\v2_0_0\ApiNew;
use asbamboo\api\_test\fixtures\apiStore\v2_0_0\ApiDelete AS ApiDelete2;
use \asbamboo\api\_test\fixtures\apiStore\v2_0_0\ApiUpdate as ApiUpdate2;
use asbamboo\api\exception\NotFoundApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ApiStoreTest extends TestCase
{
    public $ApiStore;

    public function setUp()
    {
        $namespace      = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir            = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $this->ApiStore = new ApiStore($namespace, $dir);
    }
    public function testFindApiClass()
    {
        $this->assertEquals(ApiDelete::class, $this->ApiStore->findApiClass('v1.0.0', '/api-delete/'));
        $this->assertEquals(ApiFixed::class, $this->ApiStore->findApiClass('v1.0.0', '/Api-Fixed/'));
        $this->assertEquals(ApiUpdate::class, $this->ApiStore->findApiClass('v1.0.0', '/Api-Update/'));
        $this->assertEquals(ApiFixed::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Fixed'));
        $this->assertEquals(ApiNew::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-New'));
        $this->assertEquals(ApiDelete2::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Delete'));
        $this->assertEquals(ApiUpdate2::class, $this->ApiStore->findApiClass('v2.0.0', '/Api-Update'));
    }

    public function testNotFindApiClass()
    {
        $this->expectException(NotFoundApiException::class);
        $this->ApiStore->findApiClass('v1.0.0', '/Api-New/');
    }
}
