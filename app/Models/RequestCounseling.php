<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCounseling extends Model
{
    protected $table = 'request_counseling';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fullname',
        'grade_section',
        'contact_details',
        'urgent_level',
        'content',
        'support_method',
        'status',
        'remarks',
    ];
}


