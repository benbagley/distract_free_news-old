<?php

namespace App\Services;

class bbcNews extends ServiceAbstract
{
  public function get($limit = 12)
  {
    $response = $this->client->request('GET', 'https://newsapi.org/v1/articles?source=bbc-news&sortBy=top&apiKey=' . getenv('NEWS_API'));

    return json_decode($response->getBody())->articles;
  }
}
