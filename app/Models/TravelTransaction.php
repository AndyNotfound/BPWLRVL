<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelTransaction extends Model
{
    use HasFactory;

    protected $table = 'travel_transactions';
    protected $primaryKey = 'Oid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Oid',
        'CreateBy',
        'CreatedAt',
        'Code',
        'Description',
        'Price',
        'Packages',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'CreateBy', 'user_id');
    }
    public function PackagesObj()
    {
        return $this->belongsTo(Packages::class, 'Packages', 'Oid');
    }
    // public function TrvTransactionDetailObj() { return $this->belongsTo(TravelTransactionDetail::class, 'TravelTransaction', 'Oid');  }
    public function details()
    {
        return $this->hasMany(TravelTransactionDetail::class, 'TravelTransaction', 'Oid');
    }
    public function packages()
    {
        return $this->hasMany(\App\Models\Packages::class, 'Oid', 'Packages');
    }

    public function package()
    {
        return $this->belongsTo(Packages::class, 'Packages', 'Oid');
    }
}
