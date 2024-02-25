<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CplDenganIk extends Model
{
    use HasFactory;

    protected $table = 'cpl_dengan_iks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_cpl',
        'uuid_ik',
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
