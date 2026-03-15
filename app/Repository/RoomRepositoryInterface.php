<?php

namespace App\Repository;

interface RoomRepositoryInterface
{
    public function insert(array $data);
    public function getAllRoom();
    public function getRoomGalleryByRoomId(int $id);
    public function getRoomById(int $id);
    public function getRoomByRandom();
}