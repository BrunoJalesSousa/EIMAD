<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class DelAllVideosStreamsAction
{
  use asAction;

  public function handle()
  {
    $rows = video_stream::all();

    foreach($rows as $row) {
      Storage::delete([
        $row->video,
      ]);
      $row->delete();
    }
  }
}
