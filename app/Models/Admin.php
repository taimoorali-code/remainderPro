<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; // Include SoftDeletes in the use statement
    protected $table = 'admins'; // Add this line to specify the table name


    protected $fillable = ['name', 'email', 'password'];
}
?>