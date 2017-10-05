<?php

namespace App\Services\Transformers;

class HackerNewsTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->title,
      'image'     => null,
      'content'   => null,
      'author'    => null,
      'link'      => isset($payload->url) ? $payload->url : 'https://news.ycombinator.com/item?id=' . $payload->id,
      'timestamp' => $payload->time,
      'service'   => 'Hacker News'
    ];
  }
}
