<?php

namespace App\Services;

use App\Services\HackerNews;
use App\Services\Transformers\ProductHuntTransformer;
use App\Services\Transformers\HackerNewsTransformer;
use App\Services\Transformers\RedditTransformer;
use GuzzleHttp\Client as Guzzle;

class ServiceFactory
{
  protected $client;

  protected $enabledServices = [
    'producthunt',
    'hackernews',
    'reddit',
  ];

  public function __construct(Guzzle $client)
  {
    $this->client = $client;
  }

  public function get($service, $limit = 10)
  {
    if (method_exists($this, $service) && $this->serviceIsEnabled($service)) {
      return $this->sortResponseTimetamp(
        $this->{$service}($limit)
      );
    }

    return [];
  }

  protected function hackernews($limit = 10)
  {
    $data = (new HackerNews($this->client))->get($limit);
    
    return (new HackerNewsTransformer($data))->create();
  }

  protected function reddit($limit = 10)
  {
    $data = (new Reddit($this->client))->get($limit);

    return (new RedditTransformer($data))->create();
  }

  protected function producthunt($limit = 10)
  {
    $data = (new ProductHunt($this->client))->get($limit);

    return (new ProductHuntTransformer($data))->create();
  }

  protected function serviceIsEnabled($service)
  {
    return in_array($service, $this->enabledServices);
  }

  protected function sortResponseTimetamp(array $data)
  {
    usort($data, function ($a, $b) {
      return $a['timestamp'] - $b['timestamp'];
    });

    return $data;
  }
}
