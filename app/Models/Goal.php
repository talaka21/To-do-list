<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    /** @use HasFactory<\Database\Factories\GoalsFactory> */
    use HasFactory;

    protected $fillable = ['id', 'title', 'description', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
