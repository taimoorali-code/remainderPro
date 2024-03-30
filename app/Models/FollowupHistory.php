<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowupHistory extends Model
{
    protected $fillable = ['followup_id', 'changes']; // Add other fillable fields as needed

    public function followup()
    {
        return $this->belongsTo(Followup::class);
    }
}
