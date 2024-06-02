<?php

namespace App\Http\Controllers;

use App\Jobs\PlayVideoJob;
use App\Models\video_stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class ProcessController extends Controller
{
  public function playVideo(string $slug, PlayVideoJob $job) {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handlePlay();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video ' . $video->video . ' está a reproduzir!')
      ->with('style', 'success');
  }

  public function fullscreen(PlayVideoJob $job) {
    $job->handleFullscreen();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está em tela cheia!')
      ->with('style', 'success');
  }

  public function pauseVideo(PlayVideoJob $job)
  {
    $job->handlePause();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está pausado!')
      ->with('style', 'success');
  }

  public function stopVideo(PlayVideoJob $job)
  {
    $job->handleStop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao parou!')
      ->with('style', 'success');
  }

  public function resumeVideo(PlayVideoJob $job)
  {
    $job->handleResume();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao foi retomada!')
      ->with('style', 'success');
  }

  public function loopVideo(string $slug, PlayVideoJob $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handleLoop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }

  public function loopAllVideo(PlayVideoJob $job)
  {
    $job->handleLoopAll();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }
}
