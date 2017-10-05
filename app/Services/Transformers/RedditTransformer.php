<?php

namespace App\Services\Transformers;

class RedditTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->data->title,
      'image'     => null,
      'content'   => null,
      'author'    => null,
      'link'      => 'https://reddit.com' . $payload->data->permalink,
      'timestamp' => $payload->data->created_utc,
      'service'   => 'Reddit'
    ];
  }
}
