<?php
namespace asbamboo\api\apiStore\responseFormatter;

use asbamboo\api\apiStore\ApiResponseMetadataInterface;
use asbamboo\http\ResponseInterface;
use asbamboo\api\apiStore\ApiResponseParamsInterface;
use asbamboo\http\JsonResponse;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年3月1日
 */
class JsonResponseFormatter implements ResponseFormatterInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\responseFormatter\ResponseFormatterInterface::handle()
     */
    public function handle(ApiResponseMetadataInterface $ApiResponseMetadata) : ResponseInterface
    {
        /**
         * @var \ReflectionProperty $Property
         * @var \ReflectionClass $Reflection
         */
        $response_data              = [];
        $Reflection                 = new \ReflectionClass($ApiResponseMetadata);
        foreach($Reflection->getProperties() AS $Property){
            $accessible             = $Property->setAccessible(true);
            $name                   = $Property->getName();
            $value                  = $Property->getValue($ApiResponseMetadata);
            if($value instanceof ApiResponseParamsInterface){
                if(!empty($value->getObjectVars())){
                    $response_data[$name]  = $value->getObjectVars();
                }
            }else{
                if(!is_null($value)){
                    $response_data[$name]  = $value;
                }
            }
        }
        return new JsonResponse($response_data);
    }
}