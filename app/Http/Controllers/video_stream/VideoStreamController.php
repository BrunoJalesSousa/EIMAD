<?php

namespace App\Http\Controllers\video_stream;

use App\Http\Actions\Video_stream_actions\UpdateVideoStreamsAction;
use App\Http\Controllers\Controller;
use App\Models\video_stream;
use Illuminate\Http\Request;
use App\Http\Actions\Video_stream_actions\GetAllVideoStreamsAction;
use App\Http\Actions\Video_stream_actions\CreateVideoStreamsAction;
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
      $request->validate([
        'video' => 'required|file|mimes:3gpp,mp4,mpeg,ogg,quicktime,webm,x-msvideo,x-ms-wmv,flv',
        'image' => 'nullable|file|mimes:jpg,png,jpeg',
        'command' => 'required',
        'description' => 'required'
      ]);
      $createAction->handle($request);
      return back()
        ->with( 'message', 'Video adicionado com successo!')
        ->with( 'title', 'Sucesso!' )
        ->with( 'style', 'success' );
    }

    /**
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
          'image' => 'nullable|file|mimes:jpg,png,jpeg',
          'command' => 'required',
          'description' => 'required'
        ]);
        if ($validator->fails()){
          if ($validator->errors()->first('video')) {
            $validator->errors()->add('videoUpdate', 'video');
            $validator->errors()->forget('video');
          }
          if ($validator->errors()->first('image')) {
            $validator->errors()->add('imageUpdate', 'image');
            $validator->errors()->forget('image');

          }
          if ($validator->errors()->first('command')) {
            $validator->errors()->add('commandUpdate', 'command');
            $validator->errors()->forget('command');
          }
          if ($validator->errors()->first('description')) {
            $validator->errors()->add('descriptionUpdate', 'description');
            $validator->errors()->forget('description');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(video_stream $video_stream)
    {
        //
    }
}
