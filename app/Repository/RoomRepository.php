<?php

namespace App\Repository;

use App\CommonConst;
use App\Models\Room;
use App\Models\RoomGallery;
use App\Utility;
use App\Repository\RoomAmenitiesRepository;
use App\Repository\RoomSpecialFeaturesRepository;
use Illuminate\Support\Facades\DB;

class RoomRepository implements RoomRepositoryInterface
{
    public function getAllRoom()
    {
        $data = Room::SELECT(
                    'id', 
                    'name', 
                    DB::raw('(
                        CASE
                            WHEN type = "' . CommonConst::STANDARD_ROOM_TYPE . '" THEN "Standard"
                            WHEN type = "' . CommonConst::CLUB_FLOOR_ROOM_TYPE . '" THEN "Club Floor"
                            ELSE "Suite"
                        END
                    ) AS type'), 
                    DB::raw('CONCAT(occupancy, " ", "' . CommonConst::PEOPLE . '") AS occupancy'), 
                    'bed_id', 
                    DB::raw('CONCAT(size, " ", "' . CommonConst::SIZE . '") AS size'), 
                    'view_id', 
                    'description', 
                    'detail', 
                    DB::raw('CONCAT(price_per_day, " ", "' . CommonConst::PRICE . '") AS price_per_day'), 
                    DB::raw('CONCAT(extra_bed_price_per_day, " ", "' . CommonConst::PRICE . '") AS extra_bed_price_per_day'),
                    'thumbnail'
                )
                ->whereNull('deleted_at')
                ->paginate(CommonConst::PAGINATE_PER_PAGE);
    
        return $data;
    }

    public function insert(array $data)
    {
        $name                             = $data['name'];
        $type                             = $data['type'];
        $occupancy                        = $data['occupancy'];
        $bed                              = $data['bed'];
        $size                             = $data['size'];
        $view                             = $data['view'];
        $description                      = $data['description'];
        $detail                           = $data['detail'];
        $price                            = $data['room_price'];
        $extra_bed_price                  = $data['extra_bed_price'];
        $roomObj                          = new Room();
        $roomObj->name                    = $name;
        $roomObj->type                    = $type;
        $roomObj->occupancy               = $occupancy;
        $roomObj->bed_id                  = $bed;
        $roomObj->size                    = $size;
        $roomObj->view_id                 = $view;
        $roomObj->description             = $description;
        $roomObj->detail                  = $detail;
        $roomObj->price_per_day           = $price;
        $roomObj->extra_bed_price_per_day = $extra_bed_price;
        $paramObj                         = Utility::addCreate($roomObj);
        $paramObj->save();

        $insert_id                        = $paramObj->id;
        $roomSpecialFeatureRepository     = new RoomSpecialFeaturesRepository();
        $insert_room_special_feature      = $roomSpecialFeatureRepository->insert($data['special_features'], $insert_id);
        $roomAmenitiesRepository          = new RoomAmenitiesRepository();
        $insert_room_amenities            = $roomAmenitiesRepository->insert($data['amenities'], $insert_id);

        return $paramObj;
    }

    public function getRoomGalleryByRoomId(int $id)
    {
        $room_galleries = RoomGallery::SELECT('id', 'image_name')
                            ->where('room_id', '=', $id)
                            ->whereNull('deleted_at')                    
                            ->get();

        return $room_galleries;
    }

    public function getRoomById($id)
    {
        $rooms = Room::find($id);

        return $rooms;
    }

    public function getRoomByRandom()
    {
        $columns         = [
            'id',
            'name',
            'type',
            'occupancy',
            'size',
            DB::raw('CONCAT(price_per_day, " ", "' . CommonConst::PRICE . '") AS price_per_day'),
            'extra_bed_price_per_day',
            DB::raw('CONCAT("' . CommonConst::BASE_URL . '", "' . CommonConst::IMAGE_PATH . '", id, "/thumb/", thumbnail) AS thumbnail')
        ];

        $rooms         = Room::SELECT($columns)
                        ->whereNull('deleted_at')
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();

        return $rooms;
    }
}