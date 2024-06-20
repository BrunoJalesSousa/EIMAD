<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class DelVideoStreamsAction
{
  use asAction;

  public function handle(string $slug)
  {
    $row = video_stream::where('slug', $slug);

    $values = $row->get();
    Storage::delete([
      $values[0]->video,
      $values[0]->image,
    ]);

    return $row->delete();
  }
}
