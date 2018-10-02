<?php
namespace asbamboo\api\exception;

final class Code
{
    const SYSTEM_EXCEPTION          = '999';    // ApiException
    const NOT_FOUND                 = '404';    // NotFound
    const NOTSET_API_NAME           = '801';    // NOT SET API NAME
    const NOT_SUPPORTED_FORMAT      = '802';    // NotSupportedFormatException
    const INVALID_ARGUMENT          = '901';    // InvalidArgument
    const INVALID_SIGN              = '902';    // InvalidSign
    const INVALID_TIMESTAMP         = '903';    // InvalidTimestamp
}
