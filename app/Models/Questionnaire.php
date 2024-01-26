<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'questionnaire_name',
        'public_flag',
        'vote_flag',
    ];

    public function options()
    {
        return $this->hasMany(Option::class, 'questionnaire_id');
    }
}
