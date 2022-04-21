<?php

namespace App\Http;

use App\{Http\Middleware\AdminMiddleware,
    Http\Middleware\ArtGalleryMiddleWare,
    Http\Middleware\ArtSupplierMiddleware,
    Http\Middleware\Authenticate,
    Http\Middleware\CheckForMaintenanceMode,
    Http\Middleware\Cors,
    Http\Middleware\EmailVerification,
    Http\Middleware\EncryptCookies,
    Http\Middleware\JsonResponse4All,
    Http\Middleware\RedirectIfAuthenticated,
    Http\Middleware\RoleMiddleware,
    Http\Middleware\TrimStrings,
    Http\Middleware\TrustProxies,
    Http\Middleware\UserActive,
    Http\Middleware\VerifyCsrfToken};
use Fruitcake\Cors\HandleCors;
use Illuminate\{Auth\Middleware\AuthenticateWithBasicAuth,
    Auth\Middleware\Authorize,
    Auth\Middleware\RequirePassword,
    Cookie\Middleware\AddQueuedCookiesToResponse,
    Foundation\Http\Kernel as HttpKernel,
    Foundation\Http\Middleware\ConvertEmptyStringsToNull,
    Foundation\Http\Middleware\ValidatePostSize,
    Http\Middleware\SetCacheHeaders,
    Routing\Middleware\SubstituteBindings,
    Routing\Middleware\ThrottleRequests,
    Routing\Middleware\ValidateSignature,
    Session\Middleware\StartSession,
    View\Middleware\ShareErrorsFromSession};

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        HandleCors::class,
        TrustProxies::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,

        /**
         * Newly Added Middleware
        */
        JsonResponse4All::class,
        Cors::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EmailVerification::class,

        /**
         * Newly Added Middleware
         */
        'json.response' => JsonResponse4All::class,
        'cors' => Cors::class,
        'role.auth' => RoleMiddleware::class,
        'art.gallery' => ArtGalleryMiddleWare::class,
        'art.supplier' => ArtSupplierMiddleware::class,
        'scope' => AdminMiddleware::class,
        'user.active' => UserActive::class
    ];
}
