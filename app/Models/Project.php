<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'skillsNeeded', 'userId', 'status', 'categoryId', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects')
                    ->withPivot('status')
                    ->withTimestamps(); 
    }

}