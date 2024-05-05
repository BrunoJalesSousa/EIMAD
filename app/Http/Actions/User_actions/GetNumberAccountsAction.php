<?php

namespace App\Http\Actions\User_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\user;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNumberAccountsAction
{
  use asAction;

  public function handle($data)
  {
    return User::all()->count();
  }
}
