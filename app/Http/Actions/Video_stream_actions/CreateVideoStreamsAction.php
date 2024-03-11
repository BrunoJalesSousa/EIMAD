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
    $img = $request->file('image');
    $slug = str_replace(' ', '', $request->description) . Carbon::now()->format('m-d-Y');
    $videoPath = $video->storeAs('/uploads/videos', $slug . '.' . $video->getClientOriginalExtension());
    $imagePath = $img->storeAs('/uploads/images', $slug . '.' . $img->getClientOriginalExtension());

    $video_stream = video_stream::create([
      'slug' => $slug,
      'image' => $imagePath,
      'video' => $videoPath,
      'description' => $request->description,
      'command' => $request->command,
    ]);
    return $video_stream->save();
  }
}
