<?php

namespace App\Http\Actions\Video_stream_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\File;

class GetStorageVideoStreamsAction
{
  use asAction;

  public function handle($data)
  {
    $folder_size = 0;

    $folderPath = storage_path('app/public/uploads/videos');

    foreach( File::allFiles($folderPath) as $file)
    {
      $folder_size += $file->getSize();
    }

    $folderPath = storage_path('app/public/uploads/images');

    foreach( File::allFiles($folderPath) as $file)
    {
      $folder_size += $file->getSize();
    }

    return number_format($folder_size / 1048576000,3);
  }
}
