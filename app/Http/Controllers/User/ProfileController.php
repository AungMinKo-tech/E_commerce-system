<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    //redirect change password page
    public function changePasswordPage(){
        return view('user.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        $this->checkPasswordValidate($request);

        $userRegisteredPassword = $request->user()->password; //user registered password

        if (Hash::check($request->current_password, $userRegisteredPassword)) {

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->new_password), //update the password
            ]);

            Alert::success('Success', 'စကားဝှက်ပြောင်းလဲပြီးပါပြီ။');

            return redirect('user/home');

        } else {
            Alert::error('Fail', 'စကားဝှက်အဟောင်း မမှန်ပါ။');

            return back();
        }
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

    //password validate
    private function checkPasswordValidate($request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'စကားဝှက်ဟောင်း လိုအပ်ပါသည်။',
            'new_password.required' => 'စကားဝှက်အသစ် လိုအပ်သည်။',
            'new_password.min' => 'စကားဝှက်အသစ်သည် အနည်းဆုံး အက္ခရာ 6 လုံးရှိရမည်။',
            'confirm_password.required' => 'စကားဝှက်ကို အတည်ပြုရန် လိုအပ်ပါသည်။',
            'confirm_password.same' => 'စကားဝှက်ကို အတည်ပြုရန် စကားဝှက်အသစ်နှင့် ကိုက်ညီရမည်။',
        ]);
    }
}
