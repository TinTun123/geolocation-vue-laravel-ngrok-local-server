<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address','country', 'city', 'latitude', 'longitude', 'action'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
