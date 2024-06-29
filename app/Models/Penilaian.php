<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_mahasiswa',
        'uuid_sub_cpmks',
        'nilai',
        'tahun_ajaran'
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
