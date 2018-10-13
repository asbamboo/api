<?php
namespace asbamboo\api\apiStore;

use asbamboo\http\ResponseInterface;
use asbamboo\http\RedirectResponse;
use asbamboo\http\TextResponse;

/**
 * 由于显示的声明一个属性会出现到帮助文档中，所以目标跳转的数据如果需要绑定一个属性的话只能隐式声明一个属性
 * 为了解决隐式声明的属性代码可读性问题。所以使用getRedirectResponseData方法。方法中明确隐式声明的属性值。
 * 这里只是说明可以只用隐式声明一个属性的方式绑定目标跳转提交的数据，并不是一定要这么做
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月13日
 */
abstract class ApiResponseRedirectParams extends ApiResponseParams implements ApiResponseRedirectParamsInterface
{
    const REDIRECT_TYPE_FORM_SUBMIT = 'form_submit';
    const REDIRECT_TYPE_GET_REQUEST = 'get';


    /**
     * 跳转目标url
     * - uri不能带有query string 和 fragment
     *
     * @return string
     */
    abstract protected function getRedirectUri() : string;

    /**
     * 返回像目标页面提交的数据
     *
     * @return array
     */
    abstract protected function getRedirectResponseData() :array;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\ApiResponseRedirectParamsInterface::makeRedirectResponse()
     */
    public function makeRedirectResponse() : ResponseInterface
    {
        $data   = $this->getRedirectResponseData();
        if($this->getRedirectType() == self::REDIRECT_TYPE_FORM_SUBMIT){
            $hidden_fields  = '';
            foreach($data as $key => $value){
                $hidden_fields .= sprintf(
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
                $hidden_fields
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
}