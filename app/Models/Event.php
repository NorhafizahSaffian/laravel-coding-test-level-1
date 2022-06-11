<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Event extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Uuid;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'slug',
        'startAt',
        'endAt',
        'created_at',
        'updated_at'
    ];

    protected $dates = [ 'deleted_at' ];
}
