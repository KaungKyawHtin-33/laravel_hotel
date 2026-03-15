<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSpecialFeatures extends Model
{
    use HasFactory;
    protected $table    = 'room_special_features';
    protected $fillable = [
        'room_id',
        'special_features_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
