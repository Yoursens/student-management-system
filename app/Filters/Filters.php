<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => \CodeIgniter\Filters\CSRF::class,
        'toolbar'       => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
        'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
        'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
        'auth'          => \App\Filters\AuthFilter::class,
        'apiAuth'       => \App\Filters\ApiAuthFilter::class,
    ];

    public array $required = [
        'before' => [
            'honeypot',
            'csrf',
            'invalidchars',
        ],
        'after' => [
            'toolbar',
            'secureheaders',
        ],
    ];

    public array $methods = [];

    // ─── Explicit route-level filter protection ───────────────
    public array $filters = [
        'auth' => [
            'before' => [
                'admin/*',   // all admin routes require auth
                'staff/*',   // all staff routes require auth
            ],
        ],
        'apiAuth' => [
            'before' => [
                'api/*',     // all api routes require apiAuth
            ],
        ],
    ];
}