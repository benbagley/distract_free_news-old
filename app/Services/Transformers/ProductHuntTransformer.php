<?php

namespace App\Services\Transformers;

use Carbon\Carbon;

class ProductHuntTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->name,
      'image'     => $payload->thumbnail->image_url,
      'content'   => $payload->tagline,
      'author'    => null,
      'link'      => $payload->discussion_url,
      'timestamp' => Carbon::parse($payload->created_at, 'UTC')->getTimestamp(),
      'service'   => 'ProductHunt',

      'subreddit' => null
    ];
  }
}
