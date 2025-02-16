<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;  
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'firstName', 'lastName', 
        'userStatus', 'registrationStatus', 'bio', 'linkedinURL', 'skills'
    ];
    
    public function notifications() {
        return $this->hasMany(Notification::class);
     }
     public function projects()
     {
         return $this->belongsToMany(Project::class, 'user_projects')
                     ->withPivot('status')
                     ->withTimestamps(); 
     
     }
     public function project() {
        return $this->hasMany(Project::class);
     }
}