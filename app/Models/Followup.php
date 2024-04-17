<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes; // Import the SoftDeletes trait

class Followup extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; // Include SoftDeletes in the use statement

    protected $table = 'followup'; // Add this line to specify the table name

    protected $fillable = [
        'name',
        'user_id',
        'phone',
        'dial_code',
        'notification_date',
        'address',
        'note',
        'status',
        'follow_date',
        'country',
        'state',
        'city',
        'switch'
    ];
    public function histories()
    {
        return $this->hasMany(FollowupHistory::class);
    }

    protected $dates = ['deleted_at']; // Add this line to specify the deleted_at column as a date
}
