<?php

namespace App\Http\Controllers;

use App\Models\video_stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class ProcessController extends Controller
{
  public function playVideo(string $slug) {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    Process::run('vlc storage/app/public/' . $video->video);
    return back()
      ->with('title', 'sucesso')
      ->with('message', 'Video está a reproduzir! VLC')
      ->with('style', 'success');
  }

  public function loopVideo(string $command) {
    Process::run('echo ' . $command . ' > new.txt');
    return back()
      ->with('title', 'sucesso')
      ->with('message', 'Video está a reproduzir!')
      ->with('style', 'success');
  }
}
