<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CplProdi extends Model
{
    use HasFactory;

    protected $table = 'cpl_prodis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'kode_cpl',
        'aspek',
        'deskripsi',
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
