<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Consultation extends Model
{
use HasFactory;

    protected $fillable = ['user_id', 'legal_category', 'description', 'status', 'document_path'];

    // THE BRIDGE: This tells Laravel that this case belongs to a specific client
    public function user()
    {
        return $this->belongsTo(User::class);
    }}
