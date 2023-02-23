<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'date',
        'note'
    ];

    protected $appends = ['is_today'];

    public function getIsTodayAttribute()
    {
        return Carbon::parse($this->created_at)->isToday();
    }
}
