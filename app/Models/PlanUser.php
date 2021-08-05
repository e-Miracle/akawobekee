<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'plan_id', 'name', 'email', 'phone', 'join_date', 'mature_date'
    ];
}
