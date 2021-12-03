<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\UserLastPass;
use Illuminate\Support\Facades\Password;

use Browser;

use File;

class ProfileController extends Controller
{
    /*public function checklastpass($user,$newpassword)
    {
        $userlarspass = UserLastPass::where('user_id', $user->id )->get();
        if(count($userlarspass)==0){  //ilk sifre degisimi
            $newuserlarspass = new UserLastPass;
            $newuserlarspass->user_id = $user->id;
            $newuserlarspass->password = Hash::make($newpassword);
            $newuserlarspass->save();
            return false;
        }
        else{
            $sorunyok=true;
            foreach ($userlarspass as $data){
                if(Hash::check($newpassword,$data->password)){
                        $sorunyok=false;
                    }
            }
            if($sorunyok){
                $newuserlarspass = new UserLastPass;
                $newuserlarspass->user_id = $user->id;
                $newuserlarspass->password = Hash::make($newpassword);
                $newuserlarspass->save();
                if(count($userlarspass)>2){
                    $firstuserlarspass = UserLastPass::where('user_id', $user->id )->first();
                    $firstuserlarspass->delete();
                }
                return false;
            }
            else{
                return true;
            }


        }


        return $userlarspass;
    }*/

    public function index(){
        //$user = User::find(Auth()->user());
        $user = Auth()->user();

        $devices = \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->get()->sortByDesc('last_activity');

        $result = [];
        foreach ($devices as $device){
            $result[] = Browser::parse($device->user_agent);
        }

        $current_session_id = \Session::getId();

        return view('profile',compact('user','devices','result','current_session_id'));
    }


    public function changepass(Request $request){


        $user = auth()->user();

        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        if (Hash::check($request->current_password, $user->password)) {

            ;
           if($user->checklastpass($request->password)){
               throw ValidationException::withMessages(['lastthirdpass' => 'Son 3 şifrenizden biri yeni şifreniz olamaz']);
           }
            $user->password =  Hash::make($request->password);

            $user->save();

            return  redirect()->route('profile.index')->with('success_pass','Şifre başarılı bir şekilde değişti.');
        }
        else{
            throw ValidationException::withMessages(['current_password' => 'This pass is incorrect']);
            //return back()->with('error','You have entered wrong password');
        }

    }

    public function changeavatar(Request $request){

        $user = auth()->user();

        $this->validate($request, [
            'input_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if($user->avatar_adress!=null){
            $this->deleteavatar();
        }

        if ($request->hasFile('input_img')) {
            $image = $request->file('input_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            //$this->save();
            //dd($user);
            $user->avatar_adress = $name;
            $user->save();

            return redirect()->route('profile.index')->with('success_avatar','Image Upload successfully');
        }
    }

    public function deleteavatar(){
        $user = auth()->user();
        File::delete('images/'.$user->avatar_adress);
        $user->avatar_adress = null;
        $user->save();
        return redirect()->route('profile.index')->with('success_avatar','Image Deleted successfully');
    }

}
