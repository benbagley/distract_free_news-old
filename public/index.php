<?php

require_once __DIR__ . '/../bootstrap/app.php';

if (PHP_SAPI == 'cli-server') {
    $_SERVER['SCRIPT_NAME'] = basename(__FILE__);
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$app->add($container->get('csrf'));
$app->run();
