<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $primaryKey = 'Oid';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'Oid',
        'CreateBy',
        'CreatedAt',
        'Packages',
        'Review',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'CreateBy', 'user_id');
    }

    public function packages()
    {
        return $this->hasMany(\App\Models\Packages::class, 'Oid', 'Packages');
    }
}
