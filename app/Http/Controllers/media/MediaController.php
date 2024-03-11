<?php

namespace App\Http\Controllers\media;

use App\Http\Actions\Video_stream_actions\CreateVideoStreamsAction;
use App\Http\Controllers\Controller;
use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\video_stream;
use App\Http\Actions\Video_stream_actions\GetAllVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\DelVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\DelAllVideosStreamsAction;
use Illuminate\Http\Request;

class MediaController extends Controller
{

  public function index()
  {
    //
  }

  public function videos(GetAllVideoStreamsAction $action)
  {
    $videos = $action->handle('');
    return view('eimad.media.videos.videos', compact('videos'));
  }

  public function delvideo(DelVideoStreamsAction $actionDel, string $slug)
  {
    $actionDel->handle($slug);
    return back()
      ->with( 'message', 'Video eliminado com successo!' )
      ->with( 'title', 'Sucesso' )
      ->with( 'style', 'success' );
  }

  public function delAllVideos(DelAllVideosStreamsAction $actionDel)
  {
    $actionDel->handle();
    return back()
      ->with( 'message', 'Videos eliminados com successo!' )
      ->with( 'title', 'Sucesso' )
      ->with( 'style', 'success' );
  }

}
