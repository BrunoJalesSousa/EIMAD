<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderDownVideoStreamsAction
{
  use asAction;

  public function handle(Request $request, string $slug)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $nextVideo = video_stream::where('order', $video->order+1)->first();
    if ($nextVideo == null)
      return back();
    $video->fill(['order' => $nextVideo->order]);
    $nextVideo->fill(['order' => $video->order-1]);
    $video->save();
    $nextVideo->save();
  }
}
