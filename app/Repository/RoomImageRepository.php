<?php

namespace App\Repository;

use App\Models\RoomGallery;
use App\ReturnMessage;
use App\Utility;
use App\Models\Room;

class RoomImageRepository implements RoomImageRepositoryInterface
{
    public function insert(int $id, string $image_name)
    {
        $return                        = [];
        $room_gallery_obj              = new RoomGallery();
        $room_gallery_obj->room_id     = $id;
        $room_gallery_obj->image_name  = $image_name;
        $paramObj                      = Utility::addCreate($room_gallery_obj);
        $paramObj->save();
        $return['softguideStatusCode'] = ReturnMessage::OK;

        return $return;
    }

    public function getThumbnailByRoomId(int $room_id)
    {
        $is_thumb = Room::SELECT('thumbnail')
                    ->where('id', '=', $room_id)
                    ->first();
        
        return $is_thumb;
    }

    public function updateThumb(int $id, $thumb_name)
    {
        $thumbObj = Room::find($id);
        $thumbObj->thumbnail = $thumb_name;
        $thumbObj->save();
    }

    public function getRoomGalleryById(int $id)
    {
        $gallery = RoomGallery::find($id);

        return $gallery;
    }

    public function updateRoomGallery(array $data, $db_image_name)
    {
        $return                        = [];
        $roomGalleryObj                = RoomGallery::find($data['image_id']);
        $roomGalleryObj->image_name    = $db_image_name;
        $paramObj                      = Utility::addUpdate($roomGalleryObj);
        $paramObj->save();
        $return['softguideStatusCode'] = ReturnMessage::OK;

        return $return;
    }

    public function deleteImage(int $id)
    {
        $room_gallery_obj             = RoomGallery::find($id);
        $room_gallery_obj->deleted_at = date("Y-m-d H:i:s");
        $room_gallery_obj->deleted_by = 1;
        $room_gallery_obj->save();

        return $room_gallery_obj;
    }
}