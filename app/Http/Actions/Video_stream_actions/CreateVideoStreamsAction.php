<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateVideoStreamsAction
{
  use asAction;

  public function handle(Request $request)
  {
    $video = $request->file('video');
    $description = str_replace(' ', '', $request->video->getClientOriginalName());
    $slug = str_replace(' ', '', $description) . Carbon::now()->format('m-d-Y');
    $videoPath = $video->storeAs('uploads\videos', $slug . '.' . $video->getClientOriginalExtension());
    $numberVideos = video_stream::all()->count();
    $video_stream = video_stream::create([
      'slug' => $slug,
      'video' => '\\' . $videoPath,
      'description' => $description,
      'order' => $numberVideos + 1,
    ]);
    return $video_stream->save();
  }
}
