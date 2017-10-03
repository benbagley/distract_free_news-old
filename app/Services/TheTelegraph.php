<?php

namespace App\Services;

class TheTelegraph extends ServiceAbstract
{
  public function get($limit = 10)
  {
    $response = $this->client->request('GET', 'https://newsapi.org/v1/articles?source=the-telegraph&sortBy=top&apiKey=' . getenv('NEWS_API'));

    return json_decode($response->getBody())->articles;
  }
}
