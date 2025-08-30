<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $primaryKey = 'Oid';
    public $incrementing = false;
    public $timestamps  = false;
    protected $keyType  = 'string'; // because Oid is char(38)

    protected $fillable = [
        'Oid',
        'CreateBy',
        'CreatedAt',
        'Name',
        'Title',
        'Description',
        'Location',
        'HeadImage',
        'SubImage1',
        'SubImage2',
        'ValidDateStart',
        'ValidDateEnd',
        'Price',
        'MaxCapacity',
        'Itineraries',
        'isCustomItineraries',
        'isFavorites',
        'isSeasonal',
        'isMustsee',
    ];

    protected $casts = [
        'Oid'                 => 'string',
        'ValidDateStart'      => 'datetime',
        'ValidDateEnd'        => 'datetime',
        'Price'               => 'float',
        'MaxCapacity'         => 'integer',
        // force 0/1 output instead of true/false
        'isCustomItineraries' => 'integer',
        'isFavorites'         => 'integer',
        'isSeasonal'          => 'integer',
        'isMustsee'           => 'integer',
    ];

    public function reviews()
    {
        // adjust if your FK/PK naming differs
        return $this->hasMany(review::class, 'packages', 'Oid');
    }
}
