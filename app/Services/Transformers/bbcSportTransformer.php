<?php

namespace App\Services\Transformers;

use Carbon\Carbon;

class bbcSportTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->title,
      'image'     => $payload->urlToImage,
      'content'   => $payload->description,
      'author'    => null,
      'link'      => $payload->url,
      'timestamp' => Carbon::parse($payload->publishedAt, 'UTC')->getTimestamp(),
      'service'   => 'BBC Sport'
    ];
  }
}
