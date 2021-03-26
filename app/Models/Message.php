<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $with = ['user'];

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'message',
      'read_at',
      'image',
      'user_id',
      'channel_id'
  ];

  public function user()
  {
     return $this->belongsTo(User::class);
  }
}
