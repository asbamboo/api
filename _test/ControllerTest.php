<?php
namespace asbamboo\api\_test;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiStore;
use asbamboo\http\ServerRequest;
use asbamboo\di\Container;
use asbamboo\di\ServiceMappingCollection;
use asbamboo\di\ServiceMapping;
use asbamboo\api\Controller;
use asbamboo\api\_test\fixtures\apiStore\v1_0_0\ApiFixed;
use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiResponseSigned;
use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月13日
 */
class ControlerTest extends TestCase
{
    public $Controller;

    public function testApi()
    {
        $namespace          = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir                = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $ServiceMappings    = new ServiceMappingCollection();
        $ServiceMappings->add(new ServiceMapping(['id' =>'request','class' => ServerRequest::class]));
        $ServiceMappings->add(new ServiceMapping([
            'id'            =>'api_store',
            'class'         => ApiStore::class,
            'init_params'   => ['namespace' => $namespace, 'dir' => $dir],
        ]));
        $Container          = new Container($ServiceMappings);
        $this->Controller   = $Container->get(Controller::class);
        $response       = $this->Controller->api('v1.0.0', '/api-fixed');
        $this->assertEquals(
            json_encode(['code'=>'0','message'=>'success','data'=>['id'=>'test_id']]),
            $response->getBody()->getContents()
        );
    }

    public function testApiHasSign()
    {
        $namespace          = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir                = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $ServiceMappings    = new ServiceMappingCollection();
        $Container          = new Container($ServiceMappings);
        $ServiceMappings->add(new ServiceMapping(['id' =>'request','class' => ServerRequest::class]));
        $ServiceMappings->add(new ServiceMapping([
            'id'            =>'api_store',
            'class'         => ApiStore::class,
            'init_params'   => ['namespace' => $namespace, 'dir' => $dir],
        ]));
        $ServiceMappings->add(new ServiceMapping(['id' => 'sign_checker', 'class' => SignCheckerByFixedSecurity::class]));
        $Container->get('sign_checker');
        $ServiceMappings->add(new ServiceMapping([
            'id'            =>'controller',
            'class'         => Controller::class,
            'init_params'   => ['ApiResponse' => '@'.ApiResponseSigned::class]
        ]));
        $this->Controller   = $Container->get('controller');
        $response           = $this->Controller->api('v1.0.0', '/api-sign');
        $decode_response    = json_decode($response->getBody()->getContents(),true);
        $this->assertArrayHasKey('sign', $decode_response);
    }

    public function testDoc()
    {
        $namespace          = 'asbamboo\\api\\_test\\fixtures\\apiStore\\';
        $dir                = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'api-store';
        $ServiceMappings    = new ServiceMappingCollection();
        $ServiceMappings->add(new ServiceMapping(['id' =>'request','class' => ServerRequest::class]));
        $ServiceMappings->add(new ServiceMapping([
            'id'            =>'api_store',
            'class'         => ApiStore::class,
            'init_params'   => ['namespace' => $namespace, 'dir' => $dir],
        ]));
        $Container          = new Container($ServiceMappings);
        $this->Controller   = $Container->get(Controller::class);
        $this->assertInstanceOf(ResponseInterface::class, $this->Controller->doc());
    }
}
