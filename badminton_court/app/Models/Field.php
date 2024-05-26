<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Field extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['name','field_location_id','image','price','description','open','close'];

    //relationship with field booking
    public function bookings()
    {
        return $this->hasMany(FieldBooking::class,'field_id');
    }

    //relationship with field location
    public function fieldLocation()
    {
        return $this->belongsTo(FieldLocation::class);
    }

}
