<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomCollection;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomSpecialFeaturesCollection;
use App\Http\Resources\RoomSpecialFeaturesResource;
use App\Models\RoomSpecialFeatures;
use App\Repository\RoomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    private $room_repository;

    public function __construct(RoomRepositoryInterface $room_repository)
    {
        $this->room_repository = $room_repository;
        DB::connection()->enableQueryLog();
    }

    public function index (Request $request)
    {        
        try {
            $rooms = $this->room_repository->getRoomByRandom();
            $logs  = DB::getQueryLog();
            Log::debug($logs);

            return response()->json($rooms);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }     
    }

    public function apiRoomDetail(Request $request) : RoomResource
    {
        try {
            $id   = $request->get('id'); 
            $room = $this->room_repository->getRoomById($id);

            return new RoomResource($room);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function apiGetAllRoom() : RoomCollection
    {
        try {
            $rooms = $this->room_repository->getAllRoom();

            return new RoomCollection($rooms);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function apiRoomSpecialFeature(Request $request) : RoomSpecialFeaturesCollection
    {
        $room_special_features = RoomSpecialFeatures::whereNull('deleted_at')
                                    ->get();
        
        return new RoomSpecialFeaturesCollection($room_special_features);
    }
}
