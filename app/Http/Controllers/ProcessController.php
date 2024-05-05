<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class ProcessController extends Controller
{
  public function playVideo(string $command) {
    Process::run('echo ' . $command . ' > new.txt');
    return back()
      ->with('title', 'sucesso')
      ->with('message', 'Video está a reproduzir!')
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
