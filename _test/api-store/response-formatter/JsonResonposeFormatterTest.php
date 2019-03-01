<?php
namespace asbamboo\api\_test\apiStore\responseFormatter;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\ApiResponseMetadata;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\apiStore\responseFormatter\JsonResponseFormatter;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
class JsonResponseFormatterTest extends TestCase
{
    public function testHandle()
    {
        $ApiResponseParams          = new ApiResponseParams();
        $ApiResponseParams->key1    = "value1";
        $ApiResponseParams->key2    = "value2";

        $ApiResponseMetadata        = new ApiResponseMetadata();
        $ApiResponseMetadata->setCode("100");
        $ApiResponseMetadata->setMessage("test");
        $ApiResponseMetadata->setData($ApiResponseParams);

        $JsonResponseFormatter      = new JsonResponseFormatter();
        $JsonResponse               = $JsonResponseFormatter->handle($ApiResponseMetadata);
        $this->assertEquals(json_encode([
            'code'      => '100',
            'message'   => 'test',
            'data'      => ['key1' => 'value1', 'key2' => 'value2'],
        ]), $JsonResponse->getBody()->getContents());
    }
}
