<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'Oid';

    protected $fillable = ['SecretKey', 'Password'];
    public $timestamps = false;
}
