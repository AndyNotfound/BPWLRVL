<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'packages';

    protected $primaryKey = 'Oid';

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
    ];

    public $timestamps = false;

    protected $casts = [
        'Oid' => 'string',
    ];

    public function reviews()
    {
        return $this->hasMany(review::class, 'Packages', 'Oid');
    }
}
