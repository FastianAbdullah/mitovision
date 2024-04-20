<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'Images';

    protected $primaryKey = 'imgID';

    protected $fillable = [
        'imgurl',
        'userID',
        'PatientID',
        'PatientName',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}