<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'vote_user_id',
        'option_id',
    ];

    const UPDATED_AT = null;
}
