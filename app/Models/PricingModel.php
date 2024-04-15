<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingModel extends Model
{
    use HasFactory;

    protected $primaryKey = "PID";
    protected $table = "pricing";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Plan',
    ];    
}
