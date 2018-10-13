<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\http\RedirectResponse;
use asbamboo\http\TextResponse;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月13日
 */
abstract class ApiResponseRedirectParams extends ApiResponseParams implements ApiResponseRedirectParamsInterface
{
    const REDIRECT_TYPE_FORM_SUBMIT = 'form_submit';
    const REDIRECT_TYPE_GET_REQUEST = 'get';

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseRedirectParamsInterface::makeRedirectResponse()
     */
    public function makeRedirectResponse() : ResponseInterface
    {
        $data   = get_object_vars($this);
        if($this->getRedirectType() == self::REDIRECT_TYPE_FORM_SUBMIT){
            $hiddenFields = '';
            foreach($data as $key => $value){
                $hiddenFields .= sprintf(
                    '<input type="hidden" name="%1$s" value="%2$s" />',
                    htmlentities($key, ENT_QUOTES, 'UTF-8', false),
                    htmlentities($value, ENT_QUOTES, 'UTF-8', false)
                )."\n";
            }

            $html = '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Redirecting...</title>
</head>
<body onload="document.forms[0].submit();">
    <form action="%1$s" method="post">
        <p>Redirecting to payment page...</p>
        <p>
            %2$s
            <input type="submit" value="Continue" />
        </p>
    </form>
</body>
</html>';
            $html = sprintf(
                $html,
                htmlentities($this->getRedirectUri(), ENT_QUOTES, 'UTF-8', false),
                $hiddenFields
            );
            return new TextResponse($html);
        }
        $query_string   = http_build_query($data);
        $target_uri     = $this->getRedirectUri() . '?' . $query_string;
        return new RedirectResponse($target_uri);
    }

    /**
     * 默认采用表单提交的方式实现页面跳转的响应
     *
     * @return string
     */
    protected function getRedirectType() : string
    {
        return self::REDIRECT_TYPE_FORM_SUBMIT;
    }

    /**
     * 跳转目标url
     * - uri不能带有query string 和 fragment
     *
     * @return string
     */
    abstract protected function getRedirectUri() : string;
}