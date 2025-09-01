<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //redirect edit page
    public function editProfile(){
        return view('user.profile.edit');
    }

    //update profile
    public function updateProfile(Request $request){
        // dd($request->all());
        $this->checkProfileValidate($request);

        $data = $this->getProfileData($request);

        if($request->hasFile('image')){
            if(Auth::user()->image != null){
                if(file_exists(public_path('profile/').Auth::user()->image)){
                    unlink(public_path('profile/').Auth::user()->image);
                }
            }
            $filename = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('profile/'), $filename);
            $data['profile'] = $filename;
        }else{
            $data['profile'] = Auth::user()->image;
        }

        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Success Title', 'ကိုယ်ရေးအကျဉ်းကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return to_route('user#home');
    }

    //get profile data
    private function getProfileData(Request $request){
        return [
            'name' => $request->name,
            'email'=> $request->email,
            'phone' => $request->phone,
            'address'=> $request->address,
            'city'=> $request->city,
            'profile' => $request->profile,
            'gender' => $request->gender,
            'nickname' => $request->nickname,
            'date_of_birth' => $request->date_of_birth,
        ];
    }

    //check validate
    private function checkProfileValidate($request){
        $request->validate([
            'name' => 'required',
            'email'=> 'required|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|unique:users,phone,'.Auth::user()->id,
            'address' => 'required',
            'gender' => 'required',
            'city' => 'required',
        ]);
    }
}
