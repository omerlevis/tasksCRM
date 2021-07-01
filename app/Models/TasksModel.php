<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
class TasksModel extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    public $fillable = ['id', 'title', 'body','status','created_at','destination'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::parse($date)->format('Y-m-d');
    }
    public function getDestinationAttribute($date)
    {
        return Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}
