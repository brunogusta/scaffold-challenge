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
        $user = Auth::user();

        $videos = $user->videos()->get();

        return response()->json($videos);

    }catch (Exception $e){
      return response($e, 500);
    }
  }

  public function userVideos() {
    try {
        $user = Auth::user();

        $videos = $user->video()->get();

        return response()->json($videos);

    }catch (Exception $e){
      return response($e, 500);
    }
  }

  public function store(Request $request) {
    try {

      parse_str(parse_url($request->url, PHP_URL_QUERY), $id);

      $thumbUrl = strtr('https://img.youtube.com/vi/{id}/hqdefault.jpg', [
        '{id}' => $id['v']
      ]);


      $data = ['url' => $request->url, 'name' => $request->name, 'thumbUrl' => $thumbUrl];


      $user = Auth::user();

      $video = $user->video()->create($data);

      return response()->json(['video' => $video]);
    }catch (Exception $e){
      return response($e, 500);
    }
  }


  public function destroy(Request $request, $id) {
    try {
        Video::where('id', $id)->delete();

        return response()->json(['message' => 'Video successfully deleted']);
    }catch (Exception $e){
      return response($e, 500);
    }
  }

  public function edit(Request $request, $id) {
    try {
      parse_str(parse_url($request->url, PHP_URL_QUERY), $string);

      $thumbUrl = strtr('https://img.youtube.com/vi/{id}/hqdefault.jpg', [
        '{id}' => $string['v']
      ]);

      $data = ['url' => $request->url, 'name' => $request->name, 'thumbUrl' => $thumbUrl];

      $user = Auth::user();

      $video = $user->video()->where('id', $id)->update($data);


      return response()->json(['message' => 'Video successfully updated']);
    }catch (Exception $e){
      return response($e, 500);
    }
  }
}
