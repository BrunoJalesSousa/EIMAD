<?php

namespace App\Http\Controllers;

use App\Http\Actions\User_actions\GetNumberAccountsAction;
use App\Http\Actions\Video_stream_actions\GetNumberVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\GetStorageVideoStreamsAction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(GetNumberVideoStreamsAction $nrVideosActions, GetStorageVideoStreamsAction $storageAction, GetNumberAccountsAction $nrAccountsAction): \Illuminate\Contracts\View\View
    {
      $nrVideos = $nrVideosActions->handle(' ');
      $storage = $storageAction->handle(' ');
      $nrAccounts = $nrAccountsAction->handle(' ');
      return view('eimad.dashboard.dashboard', compact('nrVideos', 'storage', 'nrAccounts'));
    }
}
