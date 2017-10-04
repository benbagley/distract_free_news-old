<?php

namespace App\Services\Transformers;

use Carbon\Carbon;

class TheIndependentTransformer extends TransformerAbstract
{
  public function transform($payload)
  {
    return [
      'title'     => $payload->title,
      'link'      => $payload->url,
      'timestamp' =>  Carbon::parse($payload->publishedAt, 'UTC')->getTimestamp(),
      'service'   => 'The Independent'
    ];
  }
}
