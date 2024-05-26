<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FieldBooking extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['user_id','field_id','date','start_time','end_time','total_price','status'];

    //relationship with field
    public function field()
    {
        return $this->belongsTo(Field::class,'field_id');
    }

    //relationship with user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
