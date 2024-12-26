<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'firstName', 
        'lastName', 
        'frontIdPic', 
        'backIdPic', 
        'userStatus', 
        'registrationStatus', 
        'CV', 
        'bio', 
        'linkedinURL', 
        'skills'
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