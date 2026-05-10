<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://localhost:8080/';
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public string $defaultLocale = 'en';
    public bool $negotiateLocale = false;
    public array $supportedLocales = ['en'];
    public string $appTimezone = 'Asia/Manila';
    public string $charset = 'UTF-8';
    public bool $forceGlobalSecureRequests = false;
    public array $proxyIPs = [];
    public string $CSRFTokenName = 'csrf_token';
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';
    public string $CSRFCookieName = 'csrf_cookie';
    public int $CSRFExpire = 7200;
    public bool $CSRFRegenerate = true;
    public bool $CSRFRedirect = false;
    public string $CSRFSameSite = 'Lax';
    public string $cookiePrefix = '';
    public string $cookieDomain = '';
    public string $cookiePath = '/';
    public bool $cookieSecure = false;
    public bool $cookieHTTPOnly = false;
    public ?string $cookieSameSite = 'Lax';
    public bool $CSPEnabled = false;
    public array $allowedHostnames = [];
    public array $trustedHostnames = [];
}