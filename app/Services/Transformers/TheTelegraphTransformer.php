<?php

namespace App\Services\Transformers;

use Carbon\Carbon;

class TheTelegraphTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->title,
      'image'     => $payload->urlToImage,
      'content'   => $payload->description,
      'author'    => null,
      'link'      => $payload->url,
      'timestamp' =>  Carbon::parse($payload->publishedAt, 'UTC')->getTimestamp(),
      'service'   => 'The Telegraph'
    ];
  }
}
