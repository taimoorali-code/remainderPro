<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Followup extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
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