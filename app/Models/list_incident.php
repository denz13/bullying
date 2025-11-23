<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class list_incident extends Model
{
    //
    protected $table = 'list_incident';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'student',
        'incident_type',
        'date_reported',
        'grade_section',
        'department',
        'status',
        'priority',
        'remarks',
        'student_image',
    ];
}
