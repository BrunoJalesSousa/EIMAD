<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllVideoStreamsAction
{
  use asAction;

  public function handle($data)
  {
    return video_stream::orderBy('order')->get();
  }
}
