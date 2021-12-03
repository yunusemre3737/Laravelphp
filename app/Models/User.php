<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar_adress',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function postlike(){
        return $this->hasMany(PostLike::class);
    }

    public function checklastpass($newpassword)
    {
        $userlarspass = UserLastPass::where('user_id', $this->id )->get();
        if(count($userlarspass)==0){  //ilk sifre degisimi
            $newuserlarspass = new UserLastPass;
            $newuserlarspass->user_id = $this->id;
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
                $newuserlarspass->user_id = $this->id;
                $newuserlarspass->password = Hash::make($newpassword);
                $newuserlarspass->save();
                if(count($userlarspass)>2){
                    $firstuserlarspass = UserLastPass::where('user_id', $this->id )->first();
                    $firstuserlarspass->delete();
                }
                return false;
            }
            else{
                return true;
            }


        }


        return $userlarspass;
    }

}
