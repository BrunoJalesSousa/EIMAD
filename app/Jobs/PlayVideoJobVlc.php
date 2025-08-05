<?php

namespace App\Jobs;

use App\Models\video_stream;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class PlayVideoJobVlc implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $command;
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

  public function handleQueueVideo()
  {
    $answer = $this->sendCommandToVLC('enqueue '. str_replace('\\', '/', storage_path('app/public' . $this->command)));
    return $answer;
  }

  public function setCommand($command)
  {
    $this->command = $command;
  }

  /**
   * Execute the job.
   */
  public function handleFullscreen()
  {
    //$openCommand = 'enqueue --one ""';
    //$this->sendCommandToVLC($openCommand);
    $answer = $this->sendCommandToVLC('fullscreen');
    return $answer;
  }



  public function handleClearQueue()
  {
    $answer = $this->sendCommandToVLC('clear');
    return $answer;
  }

  public function handlePause()
  {
    $answer = $this->sendCommandToVLC('pause');
    return $answer;
  }

  public function handleStop()
  {
    $answer = $this->sendCommandToVLC('stop');
    return $answer;
  }

  public function handlePlay()
  {

    //$response = $this->isVlcRunning();
    //if (!$response) {
    //  $this->openVLC();
    //}

    $command = 'add ' . str_replace('\\', '/', storage_path('app/public' . $this->command));
    //dd($command);
    $answer = $this->sendCommandToVLC($command);
    return $answer;
  }

    public function handleLoop()
    {
        $answer = $this->sendCommandToVLC('repeat');
        return $answer;
    }

    public function handleLoopOff()
    {
        $answer = $this->sendCommandToVLC('loop off');
        return $answer;
    }

  public function handleLoopAll()
  {
    //$this->sendCommandToVLC('clear');
    $videos = video_stream::orderBy('order', 'asc')->get();

	//dd($videos);
/*
    $playlistContent = "#EXTM3U\n"; // M3U file header

    foreach ($videos as $video) {
      $filePath = 'C:\\Users\\senro\\PhpstormProjects\\EIMAD\\storage\\app\\public\\uploads\\videos\\' . $video->filename;
      $playlistContent .= "#EXTINF:-1,$video->description\n"; // Add file information
      $playlistContent .= $filePath . "\n"; // Add file path
    }
    $playlistPath = 'C:\\Users\\senro\\PhpstormProjects\\EIMAD\\storage\\app\\allMedia.m3u';
    file_put_contents($playlistPath, $playlistContent);
    */
    $answer = true;
    foreach ($videos as $video) {
      if ($video->order == 1)
        $answer = $this->sendCommandToVLC('add ' . str_replace('\\', '/', storage_path('app/public' . $video->video)));
      else
        $answer = $this->sendCommandToVLC('enqueue ' . str_replace('\\', '/', storage_path('app/public' . $video->video)));
      if (!$answer)
        return $answer;
    }
    return $answer;
  }

  protected function sendCommandToVLC(string $command)
  {
    // Replace 'localhost' and '12345' with your VLC RC interface host and port
    $host = '127.0.0.1';
    $port = 12345;

    $fp = @fsockopen($host, $port, $errno, $errstr, 30);

    if (!$fp) {
      return back()
        ->with('message', 'Será que o VLC está aberto?.. com RC ativo?')
        ->with('title', 'Erro!')
        ->with('style', 'error');
    }

    fwrite($fp, $command . "\n");
    fclose($fp);
    return true;
  }

  protected function openVLC()
  {
    // Run the VLC command as a new process
    OpenVlcJob::dispatch();
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

  public function handleCurrentQueue()
  {
    return [];
    $playlist = $this->askVlcForQueue();
    return $this->parseQueue($playlist);
  }

  private function askVlcForQueue()
  {
    $address = '127.0.0.1';
    $port = 12345;

    // Open the socket connection
    $fp = fsockopen($address, $port, $errno, $errstr, 5);
    if (!$fp) {
      return "$errstr ($errno)<br />\n";
    }

    // Send the command
    fwrite($fp, 'playlist' . "\n");

    // Set the stream to non-blocking mode
    stream_set_blocking($fp, false);

    $response = '';
    $startTime = time();
    while (true) {
      $line = fgets($fp);

      if ($line !== false) {
        $response .= $line;
      } else {
        // Check if the timeout has been reached
        if ((time() - $startTime) > 5) {
          break;
        }
      }
    }

    fclose($fp);
    return $response;
  }

  private function parseQueue($playlist)
  {
    $lines = explode("\n", $playlist);
    $queue = [];
    $isInQueueSection = false;

    foreach ($lines as $line) {
      $line = trim($line);

      // Detect the start of the queue section
      if (str_contains($line, "|") && str_contains($line, "playlist")) {
        $isInQueueSection = true;
        continue;
      }

      // If we are in the queue section, extract the item information
      if ($isInQueueSection) {
        if (empty($line)) {
          break; // End of queue section
        }
        if (strpos($line, "|") !== false) {
          // Extract relevant parts of the line
          preg_match('/\| (.*?) \| (.*?) \|/', $line, $matches);
          if (count($matches) == 3) {
            $queue[] = [
              'id' => trim($matches[1]),
              'title' => trim($matches[2]),
            ];
          }
        }
      }
    }

    return $queue;
  }

  private function checkStatusVLC()
  {
    return true;
    // Change the IP and port if VLC is running on a different machine or port

    try {
	$fp = fsockopen("127.0.0.1", 12345, $errno, $errstr, 5);
      	// Set stream timeout (5 seconds)
        stream_set_timeout($fp, 5);

        // Send the command
      	fwrite($fp, 'status' . "\n");

      	// Set the stream to non-blocking mode
      	stream_set_blocking($fp, false);
      	// Read the response
      	$response = '';
      	while (!feof($fp)) {
            $line = fgets($fp);
            if ($line === false) {
                break;
            }
            $response .= $line;
        }

      	fclose($fp);
    } catch (Exception $e) {
	// Handle the exception by displaying an error message or
	// logging it
        return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
