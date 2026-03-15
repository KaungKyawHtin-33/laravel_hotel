<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenities extends Model
{
    use HasFactory;
    protected $table    = 'room_amenities';
    protected $fillable = [
        'room_id',
        'amenities_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
