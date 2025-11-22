<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    //
    protected $table = 'notification';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'notification_type',
        'content',
        'status',
    ];
}
