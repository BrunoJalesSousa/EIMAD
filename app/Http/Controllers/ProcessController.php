<?php

namespace App\Http\Controllers;

use App\Jobs\PlayVideoJobOmxplayer;
use App\Jobs\PlayVideoJobVlc;
use App\Models\video_stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class ProcessController extends Controller
{
  public function queueVideoOmxplayer(string $slug, PlayVideoJobOmxplayer $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handleQueueVideo();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video ' . $video->description . ' foi adicionado à fila!')
      ->with('style', 'success');
  }

  public function queueVideoVlc(string $slug, PlayVideoJobVlc $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handleQueueVideo();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video ' . $video->description . ' foi adicionado à fila!')
      ->with('style', 'success');
  }

  public function playVideoOmxplayer(string $slug, PlayVideoJobOmxplayer $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handlePlay();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video ' . $video->description . ' está a reproduzir!')
      ->with('style', 'success');
  }


  public function playVideoVlc(string $slug, PlayVideoJobVlc $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handlePlay();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video ' . $video->description . ' está a reproduzir!')
      ->with('style', 'success');
  }

  public function clearQueueOmxplayer(PlayVideoJobOmxplayer $job)
  {
    $job->handleClearQueue();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A fila foi limpa')
      ->with('style', 'success');
  }

  public function clearQueueVlc(PlayVideoJobVlc $job)
  {
    $job->handleClearQueue();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A fila foi limpa')
      ->with('style', 'success');
  }

  public function fullscreenOmxplayer(PlayVideoJobOmxplayer $job) {
    $job->handleFullscreen();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está em tela cheia!')
      ->with('style', 'success');
  }

  public function fullscreenVlc(PlayVideoJobVlc $job) {
    $job->handleFullscreen();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está em tela cheia!')
      ->with('style', 'success');
  }

  public function pauseVideoOmxplayer(PlayVideoJobOmxplayer $job)
  {
    $job->handlePause();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está pausado!')
      ->with('style', 'success');
  }

  public function pauseVideoVlc(PlayVideoJobVlc $job)
  {
    $job->handlePause();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O player está pausado!')
      ->with('style', 'success');
  }

  public function stopVideoOmxplayer(PlayVideoJobOmxplayer $job)
  {
    $job->handleStop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao parou!')
      ->with('style', 'success');
  }

  public function stopVideoVlc(PlayVideoJobVlc $job)
  {
    $job->handleStop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao parou!')
      ->with('style', 'success');
  }

  public function resumeVideoOmxPlayer(PlayVideoJobOmxplayer $job)
  {
    $job->handleResume();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao foi retomada!')
      ->with('style', 'success');
  }

  public function resumeVideoVlc(PlayVideoJobVlc $job)
  {
    $job->handleResume();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'A reproduçao foi retomada!')
      ->with('style', 'success');
  }

  public function loopVideoOmxplayer(string $slug, PlayVideoJobOmxplayer $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handleLoop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }

  public function loopVideoVlc(string $slug, PlayVideoJobVlc $job)
  {
    $video = video_stream::where('slug', $slug)->firstOrFail();
    $job->setCommand($video->video);
    $job->handleLoop();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }

  public function loopAllVideoOmxplayer(PlayVideoJobOmxplayer $job)
  {
    $job->handleLoopAll();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }

  public function loopAllVideoVlc(PlayVideoJobVlc $job)
  {
    $job->handleLoopAll();
    return back()
      ->with('title', 'Sucesso!')
      ->with('message', 'O video está em loop!')
      ->with('style', 'success');
  }
}
