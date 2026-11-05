<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrafficReport extends Model
{
    use HasFactory;

    protected $table = 'traffic_reports';

    protected $fillable = [
        'user_id',
        'nama_pelapor',
        'lokasi_jalan',
        'tingkat_kepadatan',
        'keterangan',
        'status',
        'foto_bukti',
    ];

    /**
     * Relasi ke model User (Petugas pembuat/pengelola laporan).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
