<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'task',
        'task_date',
        'status'
    ];

    protected $appends = ['is_today'];

    public function getIsTodayAttribute()
    {
        return Carbon::parse($this->created_at)->isToday();
    }
}
