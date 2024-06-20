<?php

namespace App\Http\Actions\User_actions;

use App\Http\Controllers\video_stream\VideoStreamController;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllUsersAction
{
  use asAction;

  public function handle($data)
  {
    return User::all();
  }
}
