<?php

namespace App\Jobs;

use App\Models\video_stream;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class PlayVideoJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $command;
  protected $isVlcOpen = false;

  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    //
  }

  public function handle()
  {
    $this->handlePlay();
  }

  public function setCommand($command)
  {
    $this->command = $command;
  }

  /**
   * Execute the job.
   */
  public function handleFullscreen(): void
  {
    $openCommand = 'enqueue --one ""';
    $this->sendCommandToVLC($openCommand);
    $this->sendCommandToVLC('fullscreen');
  }

  public function handlePause(): void
  {
    $this->sendCommandToVLC('pause');
  }

  public function handleStop(): void
  {
    $this->sendCommandToVLC('stop');
  }

  public function handlePlay(): void
  {
    $response = $this->checkStatusVLC('status');
    $this->sendCommandToVLC('add "'. str_replace('\\', '/', storage_path('app/public' . $this->command)) . '"');
  }

  public function handleLoop(): void
  {
    $this->sendCommandToVLC('add "'. str_replace('\\', '/', storage_path('app/public' . $this->command)) . '"');
    $this->sendCommandToVLC('repeat');
  }

  public function handleLoopAll(): void
  {
    //$this->sendCommandToVLC('clear');
    $videos = video_stream::all()->sortBy('order');

    // Generate the playlist content
    $playlistContent = "#EXTM3U\n"; // M3U file header
    foreach ($videos as $video) {
      $filePath = 'C:\\Users\\senro\\PhpstormProjects\\EIMAD\\storage\\app\\public\\uploads\\videos\\' . $video->filename;
      $playlistContent .= "#EXTINF:-1,$video->description\n"; // Add file information
      $playlistContent .= $filePath . "\n"; // Add file path
    }
    $playlistPath = 'C:\\Users\\senro\\PhpstormProjects\\EIMAD\\storage\\app\\allMedia.m3u';
    file_put_contents($playlistPath, $playlistContent);
    $this->sendCommandToVLC('enqueue ' . $playlistPath);

    //$this->sendCommandToVLC('loop on');
  }

  protected function sendCommandToVLC(string $command)
  {
    // Replace 'localhost' and '12345' with your VLC RC interface host and port
    $host = '127.0.0.1';
    $port = 12345;


    $fp = fsockopen($host, $port, $errno, $errstr, 30);
    if (!$fp) {
      throw new \RuntimeException("Failed to connect to VLC: $errstr ($errno)");
    }
    fwrite($fp, $command . "\n");
    fclose($fp);
  }

  protected function openVLC()
  {
    // Construct the full VLC command to open the video
    $vlcCommand = '"C:\\Program Files (x86)\\VideoLAN\\VLC\\vlc.exe" --intf rc --rc-host 127.0.0.1:12345';

    // Run the VLC command as a new process
    Process::fromShellCommandline($vlcCommand)->run();
    $this->isVlcOpen = true;
  }

  protected function isVlcRunning(): bool
  {
    // Replace 'localhost' and '12345' with your VLC RC interface host and port
    $host = 'localhost';
    $port = 12345;

    // Attempt to establish a connection to VLC RC interface
    $fp = @fsockopen($host, $port, $errno, $errstr, 30);
    if (!$fp) {
      // If connection is actively refused, VLC isn't running
      if ($errno === 111 || $errno === 10061 || 10060) { // Error codes for connection refused
        return false;
      }
    }

    fclose($fp);
    return true;
  }

  private function checkStatusVLC($command)
  {
    // Change the IP and port if VLC is running on a different machine or port
    $fp = fsockopen("127.0.0.1", 12345, $errno, $errstr, 30);

    if (!$fp) {
      return "$errstr ($errno)<br />\n";
    } else {
      fwrite($fp, $command . "\n");

      // Read the response
      $response = '';
      $line = fgets($fp);
      $response .= $line;

      fclose($fp);

      return $response;
    }
  }
}
