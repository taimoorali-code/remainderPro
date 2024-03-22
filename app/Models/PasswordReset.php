<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{

    use HasFactory;
    protected $primaryKey = 'email';

    const UPDATED_AT= null;
    protected $table = 'password_reset_tokens'; // Add this line to specify the table name
    protected $fillable = [
        'email',
        'token',
        'created_at',

       
    ];
   


}
