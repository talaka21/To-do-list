<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TasksFactory> */
    use HasFactory;
    protected $fillable = ['id','title','is_completed'];

    public function goal()
{
    return $this->belongsTo(Goal::class);
}
}
