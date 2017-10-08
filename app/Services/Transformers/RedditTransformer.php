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
      'author'    => $payload->data->author,
      'link'      => 'https://reddit.com' . $payload->data->permalink,
      'subreddit' => $payload->data->subreddit,
      'subreddit_link' => 'https://reddit.com/' . $payload->data->subreddit_name_prefixed,
      'timestamp' => $payload->data->created_utc,
      'service'   => 'Reddit'
    ];
  }
}
