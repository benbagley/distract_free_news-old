<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'views' => [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../storage/views'
        ],

        'database' => [
          'redis' => [
            'scheme'    => getenv('REDIS_SCHEME'),
            'host'      => getenv('REDIS_HOST'),
            'port'      => getenv('REDIS_PORT'),
            'password'  => getenv('REDIS_PASSWORD') ?: null
          ]
        ]
    ],
]);

$container = $app->getContainer();

$container['csrf'] = function ($container) {
  return new \Slim\Csrf\Guard;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => $container->settings['views']['cache'],
        'debug' => true
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new App\Views\CsrfExtension($container['csrf']));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

$container['cache'] = function($container) {
  $settings = $container['settings']['database']['redis'];

  $client = new Predis\Client([
    'scheme'    => $settings['scheme'],
    'host'      => $settings['host'],
    'port'      => $settings['port'],
    'password'  => $settings['password']
  ]);

  return new App\Cache\RedisAdapter($client);
};

$container['services'] = function ($container) {
  return new App\Services\ServiceFactory(
    new GuzzleHttp\Client,
    $container->get('cache')
  );
};

require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';
