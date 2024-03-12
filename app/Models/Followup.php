<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;
    protected $table = 'followup'; // Add this line to specify the table name


    protected $fillable = [
        'name',
        'user_id',
        'phone',
        'address',
        'note',
        'status',
        'follow_date',
        'country',
        'state',
        'city',
    ];
}