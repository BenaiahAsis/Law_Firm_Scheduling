<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id', 
        'legal_category', 
        'description', 
        'status', 
        'document_path', 
        'scheduled_at',
        'admin_notes' 
    ];

    // This tells Laravel to treat this column as a Date object, not just plain text!
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}