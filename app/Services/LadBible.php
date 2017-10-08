<?php

namespace App\Services;

class LadBible extends ServiceAbstract
{
  public function get($limit = 20)
  {
    $response = $this->client->request('GET', 'https://newsapi.org/v1/articles?source=the-lad-bible&sortBy=top&apiKey=' . getenv('NEWS_API'));

    return json_decode($response->getBody())->articles;
  }
}
