<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //redirect password change page
    public function changePassword()
    {
        return view("admin.profile.changePassword");
    }

    //update Password
    public function updatePassword(Request $request)
    {
        $this->checkPasswordValidate($request);

        // dd($request->all());

        $userRegisterPassword = $request->user()->password;

        // dd($userRegisterPassword);

        if (Hash::check($request->current_password, $userRegisterPassword)) {

            User::where("id", Auth::user()->id)->update([
                "password" => Hash::make($request->new_password)
            ]);

            Alert::success('Success', 'စကားဝှက်ပြောင်းလဲပြီးပါပြီ။');

            return redirect('admin/dashboard');
        } else {
            Alert::error('Fail', 'စကားဝှက်အဟောင်း မမှန်ပါ။');
            return back();
        }
    }

    //redirect view profile page
    public function view(){
        return view('admin.profile.view');
    }

    //redirect edit profile page
    public function editProfile(){
        return view('admin.profile.edit');
    }

    //update profile
    public function updateProfile(Request $request){
        $this->checkProfileValidate($request);

        $data = $this->getProfileData($request);
        // dd($data);
        if($request->hasFile('profile')){
            if(Auth::user()->profile != null){
                if(file_exists(public_path('profile/').Auth::user()->profile)){
                    unlink(public_path('profile/').Auth::user()->profile);
                }
            }
            $filename = uniqid().$request->file('profile')->getClientOriginalName();
            $request->file('profile')->move(public_path('profile/'), $filename);
            $data['profile'] = $filename;
        }else{
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Success Title', 'ကိုယ်ရေးအကျဉ်းကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return redirect('admin/dashboard');
    }

    //check password validate
    private function checkPasswordValidate($request)
    {
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

    //check profile validate
    private function checkProfileValidate($request){
        $request->validate([
            'name'=> 'required',
            'email' => 'required|unique:users,email,'. Auth::user()->id,
            'phone' => 'required',
            'nickname' => '',
            'date_of_birth' => '',
            'address' => 'min:5',
            'city' => 'required',
            'gender' => '',
            'profile' => 'mimes:jpg,jpeg,webp,png,gif,svg,heic'
        ],[
            'name.required' => 'အမည် လိုအပ်ပါသည်။',
            'email.required' => 'email လိုအပ်ပါသည်။',
            'email.unique' => 'အခြား email နှင့်တူညီနေပါသည်။',
            'phone.required' => 'ဖုန်းနံပတ် လိုအပ်ပါသည်။',
            'address.min' => 'လိပ်စာသည် အက္ခရာ 5 လုံးရှိရမည်။',
            'city.required' => 'မြို့မြို့အမည် လိုအပ်ပါသည်။',
        ]);
    }
}
