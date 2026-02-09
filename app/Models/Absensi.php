<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'clock_in',
        'clock_in_image',
        'clock_in_lat',
        'clock_in_long',
        'clock_out',
        'clock_out_image',
        'clock_out_lat',
        'clock_out_long',
        'late_duration',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'late_duration' => 'integer',
    ];

    /**
     * Get the user that owns the absensi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
