<?php

namespace App\Services;

use App\Cache\RedisAdapter;
use App\Services\HackerNews;
use App\Services\Transformers\HackerNewsTransformer;
use App\Services\Transformers\RedditTransformer;
use App\Services\Transformers\ProductHuntTransformer;
use App\Services\Transformers\bbcNewsTransformer;
use App\Services\Transformers\bbcSportTransformer;
use App\Services\Transformers\TheTelegraphTransformer;
use App\Services\Transformers\TheIndependentTransformer;
use GuzzleHttp\Client as Guzzle;

class ServiceFactory
{
  protected $client;
  protected $cache;

  protected $enabledServices = [
    'hackernews',
    'reddit',
    'producthunt',
    'bbcnews',
    'bbcsport',
    'thetelegraph',
    'theindependent',
  ];

  public function __construct(Guzzle $client, RedisAdapter $cache)
  {
    $this->client = $client;
    $this->cache = $cache;
  }

  public function get($service, $limit = 20)
  {
    if (method_exists($this, $service) && $this->serviceIsEnabled($service)) {
      return $this->sortResponseTimetamp(
        $this->{$service}($limit)
      );
    }

    return [];
  }

  public function hackernews($limit = 20)
  {
    $data = $this->cache->remember('hackernews', 10, function () use ($limit) {
      return json_encode((new HackerNews($this->client))->get($limit));
    });

    return (new HackerNewsTransformer(json_decode($data)))->create();
  }

  protected function reddit($limit = 20)
  {
    $data = $this->cache->remember('reddit', 10, function () use ($limit) {
      return json_encode((new Reddit($this->client))->get($limit));
    });

    return (new RedditTransformer(json_decode($data)))->create();
  }

  protected function producthunt($limit = 20)
  {
    $data = $this->cache->remember('producthunt', 10, function () use ($limit) {
      return json_encode($data = (new ProductHunt($this->client))->get($limit));
    });

    return (new ProductHuntTransformer(json_decode($data)))->create();
  }

  protected function bbcnews($limit = 20)
  {
    $data = $this->cache->remember('bbcnews', 10, function () use ($limit) {
      return json_encode($data = (new bbcNews($this->client))->get($limit));
    });

    return (new bbcNewsTransformer(json_decode($data)))->create();
  }

  protected function bbcsport($limit = 20)
  {
    $data = $this->cache->remember('bbcsport', 10, function () use ($limit) {
      return json_encode($data = (new bbcSport($this->client))->get($limit));
    });

    return (new bbcSportTransformer(json_decode($data)))->create();
  }

  protected function thetelegraph($limit = 20)
  {
    $data = $this->cache->remember('thetelegraph', 10, function () use ($limit) {
      return json_encode($data = (new TheTelegraph($this->client))->get($limit));
    });

    return (new TheTelegraphTransformer(json_decode($data)))->create();
  }

  protected function theindependent($limit = 20)
  {
    $data = $this->cache->remember('theindependent', 10, function () use ($limit) {
      return json_encode($data = (new TheIndependent($this->client))->get($limit));
    });

    return (new TheIndependentTransformer(json_decode($data)))->create();
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
