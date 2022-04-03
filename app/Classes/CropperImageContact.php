<?php

namespace App\Classes;

use App\Models\User;
use App\Contracts\Cropper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CropperImageContact implements Cropper
{
        public function Crop($request)
        {
                $image_parts = explode(";base64,", $request->photo);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                $image = base64_decode($image_parts[1]);

		$path='vcard/'.uniqid().'.'.$image_type;

                Storage::disk('public')->put($path, $image);

                return $path;
        }

}

