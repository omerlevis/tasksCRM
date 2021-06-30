<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    public $fillable = ['id', 'title', 'body','status','created_at'];
}
