<?php

namespace App\Services;

class ProductHunt extends ServiceAbstract
{
  public function get($limit = 20)
  {
    $response = $this->client->request('GET', 'https://api.producthunt.com/v1/posts?access_token=' . getenv('PRODUCT_HUNT'));

    return json_decode($response->getBody())->posts;
  }
}
