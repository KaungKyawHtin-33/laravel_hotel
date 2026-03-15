<?php

namespace App\Repository;

interface RoomImageRepositoryInterface
{
    public function insert(int $id, string $image_name);
    public function getThumbnailByRoomId(int $room_id);
    public function getRoomGalleryById(int $id);
    public function updateThumb(int $id, $thumb_name);
    public function updateRoomGallery(array $data, $db_image_name);
    public function deleteImage(int $id);
}