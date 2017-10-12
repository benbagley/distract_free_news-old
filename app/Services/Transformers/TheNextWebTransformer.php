<?php

namespace App\Services\Transformers;

use Carbon\Carbon;

class TheNextWebTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->title,
      'image'     => $payload->urlToImage,
      'content'   => $payload->description,
      'author'    => $payload->author,
      'link'      => $payload->url,
      'timestamp' => Carbon::parse($payload->publishedAt, 'UTC')->getTimestamp(),
      'service'   => 'The Next Web',

      'subreddit' => null,
    ];
  }
}
