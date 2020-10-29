<?php
namespace App\Http\Controllers;
use App\FileUpload;

use Illuminate\Http\Request;
use App\Http\Services\ImageService;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService) {
      $this->imageService = $imageService;
    }

    public function store(Request $request)
    {
       if($request->hasFile('file'))
       {
         return $this->imageService->storeImageToFolder($request, 'images');
       }

       return response()->json(['error' => 'Đã xảy ra lỗi gì đó, vui lòng kiểm tra lại'], 500);
    }
}