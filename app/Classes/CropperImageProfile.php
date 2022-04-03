<?php

namespace App\Classes;

use App\Models\User;
use App\Contracts\Cropper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CropperImageProfile implements Cropper
{
	public function Crop($request)
    	{
		$image_parts = explode(";base64,", $request->image);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];

		$image = base64_decode($image_parts[1]);

		Storage::disk('public')->put('image/avatar'.$request->user.'.'.$image_type, $image);

		$path='image/avatar'.$request->user.'.'.$image_type;
		
		return $path;
	}

	public function destroy($id)
    	{
		$user=User::find($id);
		Storage::delete($user->image);
		$user->image = NULL;
		$user->save();

		return true;
    	}	

}

