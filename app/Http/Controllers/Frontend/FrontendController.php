<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\RoomRepositoryInterface;

class FrontendController extends Controller
{
    private $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository           = $roomRepository;      
        DB::connection()->enableQueryLog();
    }

    public function index()
    {
        $data = $this->roomRepository->getAllRoom();

        return view('index', compact([
            'data'
        ])); 
    }
}
