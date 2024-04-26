<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'Images';
    public $timestamps = false;
    protected $primaryKey = 'imgID';

    protected $fillable = [
        'imgurl',
        'user_id',
        'patiend_id',
        'patient_name',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}