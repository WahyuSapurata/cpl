<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SubCpmk extends Model
{
    use HasFactory;

    protected $table = 'sub_cpmks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_user',
        'uuid_matkul',
        'uuid_cpmk',
        'nama_sub',
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
