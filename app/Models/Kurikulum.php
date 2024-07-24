<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'kode',
        'nama',
        'tahun_mulai',
        'tahun_berakhir',
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
