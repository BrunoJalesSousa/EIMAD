<?php

namespace App\Jobs;

use App\Models\video_stream;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class PlayVideoJobOmxplayer implements ShouldQueue
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
    $this->sendCommandToVLC('enqueue "'. str_replace('\\', '/', storage_path('app/public' . $this->command)) . '"');
  }

  public function setCommand($command)
  {
    $this->command = $command;
  }

  public function handleStop(): void
  {
    exec('killall "omxplayer.bin"');
  }

  public function handlePlay(): void
  {
    $command = 'sudo omxplayer -p -o hdmi ' . str_replace('\\', '/', storage_path('app/public' . $this->command));
    exec($command, $output, $returnVar);
  }

  public function handleLoop(): void
  {
    exec('sudo omxplayer --loop -p -o hdmi ' . str_replace('\\', '/', storage_path('app/public' . $this->command)));
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
    $fp = fsockopen("127.0.0.1", 12345, $errno, $errstr, 5);

    if (!$fp) {
      return "$errstr ($errno)<br />\n";
    } else {
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

      return $response;
    }
  }
}
