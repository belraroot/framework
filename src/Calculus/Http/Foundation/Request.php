<?php

namespace Calculus\Http\Foundation;

use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request as BaseRequest;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Request extends BaseRequest
{
    /**
     * @var \Symfony\Component\HttpFoundation\InputBag|null
     */
    protected $json;

    /**
     * @return BaseRequest
     */
    public static function capture()
    {
        static::enableHttpMethodParameterOverride();

        return BaseRequest::createFromGlobals();
    }

    /**
     * @return $this
     */
    public function instance()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function method()
    {
        return $this->getMethod();
    }

    /**
     * @return string
     */
    public function root()
    {
        return rtrim($this->getSchemeAndHttpHost() . $this->getBaseUrl(), '/');
    }

    /**
     * @return string
     */
    public function url()
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    /**
     * @return string
     */
    public function fullUrl()
    {
        $query = $this->getQueryString();

        $question = $this->getBaseUrl() . $this->getPathInfo() === '/' ? '/?' : '?';

        return $query ? $this->url() . $question . $query : $this->url();
    }
}