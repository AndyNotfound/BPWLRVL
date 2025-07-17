<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelTransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'travel_transaction_details';

    protected $primaryKey = 'Oid';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'Oid',
        'CreateBy',
        'CreatedAt',
        'TravelTransaction',
        'Code',
        'Description',
        'TotalPax',
        'Name',
        'Email',
        'Status',
        'PhoneNumber',
        'EnterDate',
        'ExitDate',
        'isCustomItineraries',
        'Itineraries',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'CreateBy', 'user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(TravelTransaction::class, 'TravelTransaction', 'Oid');
    }

    public function ItinerariesObj()
    {
        return $this->belongsTo(Itineraries::class, 'Itineraries', 'Oid');
    }
}
