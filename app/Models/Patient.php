<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'name',
        'number',
        'blood_group',
        'gender',
        'address'
    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}
