<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $table    = 'room';
    protected $fillable = [
        'name',
        'type',
        'occupancy',
        'bed_id',
        'size',
        'view_id',
        'description',
        'detail',
        'price_per_day',
        'extra_bed_price_per_day',
        'thumbnail',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getBed()
    {
        return $this->belongsTo(
            Bed::class,
            'bed_id',
            'id'
        );
    }

    public function getView()
    {
        return $this->belongsTo(
            View::class,
            'view_id',
            'id'
        );
    }

    public function getRoomGalleriesByRoom() : HasMany
    {
        return $this->hasMany(RoomGallery::class, 'room_id', 'id');
    }
}
