<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itineraries extends Model
{
    use HasFactory;

    protected $table = 'itineraries';

    protected $primaryKey = 'Oid';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'Oid',
        'CreateBy',
        'CreatedAt',
        'Code',
        'Name',
    ];
}
