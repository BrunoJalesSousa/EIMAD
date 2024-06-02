<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\File;


class SyncWithFolderVideoStreamsAction
{
  use asAction;

  public function handle()
  {
    $directoryPath = storage_path('app\public\uploads\videos'); // Replace with your directory path

    // Get all files in the specified directory
    $files = File::files($directoryPath);

    // If you need all files including those in subdirectories, use File::allFiles()
    // $files = File::allFiles($directoryPath);

    // Extract the file names
    $fileNames = array_map(function ($file) {
      return $file->getFilename();
    }, $files);

    foreach ($fileNames as $file) {
      $video = video_stream::where('video', '\uploads\videos\\' . $file)->first();
      if ($video == null) {
        $description = str_replace(' ', '', $file);
        $slug = $description . Carbon::now()->format('m-d-Y');
        $numberVideos = video_stream::all()->count();
        $video_stream = video_stream::create([
          'slug' => $slug,
          'video' => '\uploads\videos\\'. $file,
          'description' => $description,
          'order' => $numberVideos + 1,
        ]);
        $video_stream->save();
      }

    }
  }
}
