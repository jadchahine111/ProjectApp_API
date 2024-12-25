<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class User extends Model
{
    use HasFactory;

    public function notifications() {
        return $this->hasMany(Notification::class);
     }
     
}
