<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $fillable = ['name', 'url', 'thumbUrl'];

  public function user() {
    return $this->belongsTo('App\User');
}
}
