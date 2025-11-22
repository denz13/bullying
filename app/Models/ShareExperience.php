<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareExperience extends Model
{
    protected $table = 'share_experience';

    protected $fillable = [
        'type_experience',
        'content',
        'type_of_support',
        'is_anonymously',
        'status',
    ];
}

