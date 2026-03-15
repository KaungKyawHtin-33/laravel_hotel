<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Repository\AmenitiesRepository;
use App\Repository\BedRepositoryInterface;
use App\Repository\RoomRepositoryInterface;
use App\Repository\ViewRepositoryInterface;
use App\Repository\RoomImageRepositoryInterface;
use App\Repository\SpecialFeatureRepositoryInterface;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomImageStoreRequest;
use App\Http\Requests\RoomImageUpdateRequest;
use App\CommonConst;
use App\ReturnMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    private $roomRepository;
    private $viewRepository;
    private $bedRepository;
    private $specialFeatureRepository;
    private $roomImageRepository;

    public function __construct(RoomRepositoryInterface $roomRepository, ViewRepositoryInterface $viewRepository, BedRepositoryInterface $bedRepository, SpecialFeatureRepositoryInterface $specialFeatureRepository, RoomImageRepositoryInterface $roomImageRepository)
    {
        $this->specialFeatureRepository = $specialFeatureRepository;
        $this->roomRepository           = $roomRepository;
        $this->viewRepository           = $viewRepository;
        $this->bedRepository            = $bedRepository;
        $this->roomImageRepository      = $roomImageRepository;
        DB::connection()->enableQueryLog();
    }

    public function index()
    {
        try {
            $data = $this->roomRepository->getAllRoom();
            $log  = DB::getQueryLog();
            Log::debug($log);

            return view('room.index', compact([
                'data'
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function create()
    {
        try {
            $special_features  = $this->specialFeatureRepository->getAllSpecialFeature();
            $views             = $this->viewRepository->getAllView();
            $beds              = $this->bedRepository->getAllBed();
            $amenities         = new AmenitiesRepository();
            $general_amenities = $amenities->getAmenitiesByType(CommonConst::GENERAL_AMENITIES);
            $bedroom_amenities = $amenities->getAmenitiesByType(CommonConst::BEDROOM_AMENITIES);
            $others_amenities  = $amenities->getAmenitiesByType(CommonConst::OTHERS_AMENITIES);

            $log               = DB::getQueryLog();
            Log::debug($log);

            return view('room.form', compact([
                'views',
                'beds',
                'special_features',
                'general_amenities',
                'bedroom_amenities',
                'others_amenities'
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function store(RoomStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data        = $request->all();
            $insert_room = $this->roomRepository->insert($data);
            $room_id     = $insert_room->id;
            $log         = DB::getQueryLog();
            Log::debug($log);
            DB::commit();

            return redirect('/backend/room/image/manage/' . $room_id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function createImage($id)
    {
        try {
            $room_galleries = $this->roomRepository->getRoomGalleryByRoomId($id);
            $log            = DB::getQueryLog();
            Log::debug($log);

            return view('room.form-image', compact([
                'id',
                'room_galleries'
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }        
    }

    public function storeImage(RoomImageStoreRequest $request)
    {  
        try {
            $room_id       = $request->get('id');
            $image_name    = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension     = $request->file('file')->extension();
            $timestamp     = time();
            $unique_number = rand(10, 1000);
            $db_image_name = $image_name . "_" . $timestamp . $unique_number . "." . $extension;
            
            $insert_image  = $this->roomImageRepository->insert($room_id, $db_image_name);

            if ($insert_image['softguideStatusCode'] == ReturnMessage::OK) {
                $upload_path    = public_path(CommonConst::IMAGE_PATH . $room_id);
                $uploaded_image = $upload_path . '/' . $db_image_name;

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                $request->file('file')->move($upload_path, $db_image_name);
                $is_thumb = $this->roomImageRepository->getThumbnailByRoomId($room_id);

                if ($is_thumb->thumbnail == null) {
                    $thumb_data = [
                        'upload_path'    => $upload_path,
                        'uploaded_image' => $uploaded_image,
                        'db_image_name'  => $db_image_name,
                        'room_id'        => $room_id
                    ];
                    self::createThumb($thumb_data);
                } 
            }

            $log          = DB::getQueryLog();
            Log::debug($log);

            return redirect()->back()->with('success_message', 'Upload Success!!!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }        
    }

    public function editImage($room_id, $gallery_id, $thumb)    
    {
        try {
            $gallery = $this->roomImageRepository->getRoomGalleryById($gallery_id);
            $log     = DB::getQueryLog();
            Log::debug($log);

            return view('room.form-image-update', compact([
                'room_id',
                'gallery_id',
                'thumb',
                'gallery'
            ]));   
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }       
    }

    public function updateImage(RoomImageUpdateRequest $request)
    {
        try {
            $data          = $request->all();
            $image_name    = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension     = $request->file('file')->extension();
            $timestamp     = time();
            $unique_number = rand(10, 1000);
            $db_image_name = $image_name . "_" . $timestamp . $unique_number . "." . $extension;
            $update_image  = $this->roomImageRepository->updateRoomGallery($data, $db_image_name);

            if ($update_image['softguideStatusCode'] == ReturnMessage::OK) {
                $upload_path    = public_path(CommonConst::IMAGE_PATH . $data['room_id']);
                $uploaded_image = $upload_path . '/' . $db_image_name;
                $request->file('file')->move($upload_path, $db_image_name);
               
                if ($data['is_thumb'] == 'yes') {               
                    $thumb_data = [
                        'upload_path'    => $upload_path,
                        'uploaded_image' => $uploaded_image,
                        'db_image_name'  => $db_image_name,
                        'room_id'        => $data['room_id']
                    ];
                    self::createThumb($thumb_data); 
                }
            }

            $log          = DB::getQueryLog();
            Log::debug($log);

            return redirect('/backend/room/image/manage/' . $data['room_id'])->with('success_message', 'Edit image success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }       
    }

    public function deleteImage($room_id, $gallery_id)
    {
        try {
            $delete_image = $this->roomImageRepository->deleteImage($gallery_id);
            $log          = DB::getQueryLog();
            Log::debug($log);

            return redirect('/backend/room/image/manage/' . $room_id)->with('success_message', 'Delete image success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }  
    }

    private function createThumb($thumb_data)
    {
        $upload_path    = $thumb_data['upload_path'];
        $uploaded_image = $thumb_data['uploaded_image'];
        $db_image_name  = $thumb_data['db_image_name'];
        $room_id        = $thumb_data['room_id'];
        $thumb_path     = $upload_path . '/thumb/';

        if (!file_exists($thumb_path)) {
            mkdir($thumb_path, 0777, true);
        }

        $thumb_name = 'thumb_' . $db_image_name;
        $image_file = Image::make($uploaded_image);

        $image_file->resize(CommonConst::THUMB_WIDTH, CommonConst::THUMB_HEIGHT, function($constraint) {
            $constraint->aspectRatio();
        })->save($thumb_path . $thumb_name);

        $update_thumb = $this->roomImageRepository->updateThumb($room_id, $thumb_name);
        $watermark    = Image::make($thumb_path . $thumb_name);
        $watermark->insert(public_path('assets/images/watermark.png'), 'bottom-right', 10, 10);
        $watermark->save($thumb_path .$thumb_name);
    }
}
