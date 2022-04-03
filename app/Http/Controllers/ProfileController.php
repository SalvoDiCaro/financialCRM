<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use JeroenDesloovere\VCard\VCard;
use JeroenDesloovere\VCard\VCardParser;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Hash;
use App\Classes\CropperImageProfile;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function CropperUpload(Request $request)
    {
        $crop = new CropperImageProfile();
        $path = $crop->Crop($request);

        Auth::user()->image = $path;
        Auth::user()->save();

        return response()->json(['success' => 'success']);
    }

    public function destroyImage($id)
    {
        $crop = new CropperImageProfile();
        $temp = $crop->destroy($id);

        return redirect()->route('profile')
            ->with('success', 'UserImage deleted successfully');
    }

    public function deleteProfile($id)
    {
        $user = User::find($id);
        $user->delete();

        return view('auth.login');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        $user->update($input);

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully');
    }
}
