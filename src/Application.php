<?php
declare(strict_types=1);

namespace App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements
    AuthenticationServiceProviderInterface,
    AuthorizationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));

        if (PHP_SAPI !== 'cli' && Configure::read('debug')) {
            if (!$this->getPlugins()->has('DebugKit')) {
                $this->addPlugin('DebugKit');
            }
        }
        if (!$this->getPlugins()->has('Authentication')) {
            $this->addPlugin('Authentication');
        }
        if (!$this->getPlugins()->has('Authorization')) {
            $this->addPlugin('Authorization');
        }
        if (!$this->getPlugins()->has('Migrations')) {
            $this->addPlugin('Migrations');
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new \Cake\Http\Middleware\BodyParserMiddleware())
            ->add(new \Cake\Http\Middleware\CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            ->add(new AuthenticationMiddleware($this))
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function ($auth, $user) {
                    if (method_exists($user, 'setAuthorization')) {
                        return $user->setAuthorization($auth);
                    }
                    return new \Authorization\IdentityDecorator($auth, $user);
                },
                'requireAuthorizationCheck' => true,
            ]));

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $service->setConfig([
            'unauthenticatedRedirect' => '/users/login',
            'queryParam' => 'redirect',
        ]);

        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        $service->loadIdentifier('Authentication.Password', compact('fields'));
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();
        return new AuthorizationService($resolver);
    }

    public function services(ContainerInterface $container): void
    {
    }
}
