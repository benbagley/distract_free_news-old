<?php

namespace App\Services;

class Reddit extends ServiceAbstract
{
  public function get($limit = 20)
  {
    $response = $this->client->request('GET', 'https://www.reddit.com/r/all.json?limit=' . $limit, [
      'headers' => ['User-Agent' => getenv('APP_NAME')]
    ]);

    return json_decode($response->getBody())->data->children;
  }
}
