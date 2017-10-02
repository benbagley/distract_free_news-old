<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class HomeController extends Controller
{
    public function index(Request $request, Response $response, $args)
    {
      $name = $this->c->cache->remember('name', 1, function() {
        sleep(10);
        return 'Ben Bagley';
      });

      dump($name);
      die();

        return $this->c->view->render($response, 'home/index.twig', [
            'appName' => $this->c->settings['app']['name'],
        ]);
    }
}
