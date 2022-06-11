<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Event extends Model
{
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
}
