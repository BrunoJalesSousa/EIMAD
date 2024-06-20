<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateVideoStreamsAction
{
  use asAction;

  public function handle(Request $request, string $slug)
  {
    $row = video_stream::where('slug', $slug);

    if ($request->file('image') != null) {
      $img = $request->file('image');
      $slug = str_replace(' ', '', $request->description) . Carbon::now()->format('m-d-Y');
      $imagePath = $img->storeAs('/uploads/images', $slug . '.' . $img->getClientOriginalExtension());
      $request->image = $imagePath;
      Storage::delete([
        $row->image,
      ]);
    }
    if ($request->file('video') != null) {
      $video = $request->file('video');
      $slug = str_replace(' ', '', $request->description) . Carbon::now()->format('m-d-Y');
      $videoPath = $video->storeAs('/uploads/video', $slug . '.' . $video->getClientOriginalExtension());
      $request->video = $videoPath;
      Storage::delete([
        $row->video,
      ]);
    }

    $values = $request->toArray();
    unset($values['_token']);
    unset($values['_method']);

    return $row->update($values);
  }
}
