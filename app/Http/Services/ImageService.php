<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
class ImageService
{
    public function storeImageToFolder($request, $folder) {
        $image = $request->file('file');
        $fileName   = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs("public/$folder", $fileName);
        return env('APP_URL')."/storage/$folder/$fileName";
    }
}