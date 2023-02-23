<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Time extends Model
{
    use HasFactory;

    protected $table = 'times';

    protected $primaryKey = 'id';

    protected $fillable = [
        'date',
        'start',
        'end',
        'description'
    ];

    protected $appends = ['is_today'];

    public function getIsTodayAttribute()
    {
        return Carbon::parse($this->created_at)->isToday();
    }
}
