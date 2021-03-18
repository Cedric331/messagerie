<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

         /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id',
      'name'
  ];

  public function messages()
  {
      return $this->hasMany(Message::class);
  }

  public function user()
  {
      return $this->belongsToMany(User::class, 'channel_users');
  }
}
