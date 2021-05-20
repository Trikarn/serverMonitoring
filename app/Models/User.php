<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // public $userId = Auth::id();

    // public $userData = Auth::user();

    public static function findByEmail($email) 
    {
        return User::where('email',$email)->first();
    }

    public function isAdmin()
    {
        $isAdmin = User::where('type','admin')
            ->where('id',Auth::id())
            ->limit(1)
            ->get();
        
        if(count($isAdmin) == 1) return true;
        return false;
    }

    public function users()
    {
        $users = DB::table('users')->where('type', 'partner')
            ->get();

        return $users;
    }

}
