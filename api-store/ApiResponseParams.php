<?php
namespace asbamboo\api\apiStore;

class ApiResponseParams implements ApiResponseParamsInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseParamsInterface::getObjectVars()
     */
    public function getObjectVars() : ?array
    {
        return get_object_vars($this);
    }
}
