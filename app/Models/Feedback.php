<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; // Include SoftDeletes in the use statement
    protected $table = 'feedbacks'; // Add this line to specify the table name


    protected $fillable = ['name', 'email', 'dial_code', 'mobile_number', 'feedback'];
}
?>