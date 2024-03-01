<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class IndikatorKinerja extends Model
{
    use HasFactory;

    protected $table = 'indikator_kinerjas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'kode_ik',
        'kemampuan',
        'deskripsi',
        'bobot',
    ];

    protected static function boot()
    {
        parent::boot();

        // Event listener untuk membuat UUID sebelum menyimpan
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
