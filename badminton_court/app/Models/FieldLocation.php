<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class FieldLocation extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'field_locations';
    protected $fillable = ['name','address','slug','user_id'];

    //generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function($category){
            $category->slug =Str::slug($category->name);
        });
    }

    //relationship with field
    public function fields()
    {
        return $this->hasMany(Field::class,'field_location_id');
    }

    //relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
