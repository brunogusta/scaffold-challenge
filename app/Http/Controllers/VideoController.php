<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Video;

class VideoController extends Controller
{
  public function index() {
    try {
        $videos = Video::all();

        return response()->json($videos);

    }catch (Exception $e){
      return response('Unexpected error fetch all videos, try again', 500);
    }
  }

  public function userVideos() {
    try {
        $user = Auth::user();

        $videos = $user->video()->get();

        return response()->json($videos);

    }catch (Exception $e){
      return response('Unexpected error on fetch user videos, try again', 500);
    }
  }

  public function store(Request $request) {
    try {

      if (!filter_var($request->url, FILTER_VALIDATE_URL)) {
        return response('Invalid youtube url.', 400);
      }

      parse_str(parse_url($request->url, PHP_URL_QUERY), $id);


      $thumbUrl = strtr('https://img.youtube.com/vi/{id}/hqdefault.jpg', [
        '{id}' => $id['v']
      ]);



      $data = ['url' => $request->url, 'name' => $request->name, 'thumbUrl' => $thumbUrl];


      $user = Auth::user();

      $video = $user->video()->create($data);

      return response()->json(['video' => $video]);
    }catch (Exception $e){
      return response('Unexpected error on save a new video, try again', 500);
    }
  }


  public function destroy(Request $request, $id) {
    try {
        Video::where('id', $id)->delete();

        return response()->json(['message' => 'Video successfully deleted']);
    }catch (Exception $e){
      return response('Unexpected error on delete a video, try again', 500);
    }
  }

  public function edit(Request $request, $id) {
    try {

      if (!filter_var($request->url, FILTER_VALIDATE_URL)) {
        return response('Invalid youtube url.', 400);
      }

      parse_str(parse_url($request->url, PHP_URL_QUERY), $hash);

      $thumbUrl = strtr('https://img.youtube.com/vi/{id}/hqdefault.jpg', [
        '{id}' => $hash['v']
      ]);

      $data = ['url' => $request->url, 'name' => $request->name, 'thumbUrl' => $thumbUrl];

      $user = Auth::user();

      $video = $user->video()->where('id', $id)->update($data);


      return response()->json(['message' => 'Video successfully updated']);
    }catch (Exception $e){
      return response('Unexpected error on update a video', 500);
    }
  }
}
