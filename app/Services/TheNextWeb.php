<?php

namespace App\Services;

class TheNextWeb extends ServiceAbstract
{
  public function get($limit = 20)
  {
    $response = $this->client->request('GET', 'https://newsapi.org/v1/articles?source=the-next-web&sortBy=latest&apiKey=' . getenv('NEWS_API'));

    return json_decode($response->getBody())->articles;
  }
}
