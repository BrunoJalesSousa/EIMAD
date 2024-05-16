<?php

namespace App\Http\Controllers\video_stream;

use App\Http\Actions\Video_stream_actions\OrderDownVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\OrderUpVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\UpdateVideoStreamsAction;
use App\Http\Controllers\Controller;
use App\Models\video_stream;
use Illuminate\Http\Request;
use App\Http\Actions\Video_stream_actions\GetAllVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\CreateVideoStreamsAction;
use Illuminate\Support\Facades\Validator;

class VideoStreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $data, GetAllVideoStreamsAction $action ): \Illuminate\Database\Eloquent\Collection
    {
        return $action->handle($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateVideoStreamsAction $createAction): \Illuminate\Http\RedirectResponse
    {
      $validator = Validator::make($request->all(), [
        'video' => 'required|mimetypes:video/mp4,video/webm,video/ogg',
      ]);

      if ($validator->fails()) {
        return redirect()
          ->back()
          ->withErrors($validator->errors())
          ->withInput($request->all())
          ->with('message', 'Video não inserido, existem valores inválidos nos campos.')
          ->with('title', 'Campos inválidos!')
          ->with('style', 'warning');
      }

      $createAction->handle($request);
      return back()
        ->with( 'message', 'Video adicionado com successo!')
        ->with( 'title', 'Sucesso!' )
        ->with( 'style', 'success' );
    }

    /*
     * Display the specified resource.
     */
    public function show(video_stream $video_stream)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(video_stream $video_stream)
    {

    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, string $slug, UpdateVideoStreamsAction $action)
  {
    $validator = validator()->make($request->all(), [
      'video' => 'nullable|file|file|mimes:3gpp,mp4,mpeg,ogg,quicktime,webm,x-msvideo,x-ms-wmv,flv',
    ]);
    if ($validator->fails()){
      if ($validator->errors()->first('video')) {
        $validator->errors()->add('videoUpdate', 'video');
        $validator->errors()->forget('video');
      }
      return redirect()->back()->withErrors($validator)
        ->with('message', 'Não foi possivel atualizar o video...')
        ->with('title', 'Sem sucesso')
        ->with('style', 'warning')
        ->with('edit-modal', $slug);
    }

    $action->handle($request, $slug);
    return back()
      ->with( 'message', 'Video atualizado com sucesso!')
      ->with('title', 'Sucesso!')
      ->with('style', 'success');
  }

  public function orderUp(Request $request, string $slug, OrderUpVideoStreamsAction $action)
  {
    $action->handle($request, $slug);
    return back();
  }

  public function orderDown(Request $request, string $slug, OrderDownVideoStreamsAction $action)
  {
    $action->handle($request, $slug);
    return back();
  }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(video_stream $video_stream)
    {
        //
    }
}
