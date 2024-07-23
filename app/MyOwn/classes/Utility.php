<?php
namespace App\MyOwn\classes;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Utility
{
    public static function viewAlert(string $type,string $message){
        session()->flash('alert',[
            'type' => $type,
            'message' => $message
        ]);
    }

    // public static function sendVerificationCode(string $email): string
    // {
    //     $permitted_chars = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $code = substr(str_shuffle($permitted_chars), 0, 6);
    //     session(['plain' => $code]);
    //     // Mail::to($email)->send(new ValidationMailable($code));
    //     return Hash::make($code);
    // }

    public static function checkAuth(): bool
    {
        return Http::authtoken()->get('/user')->successful();
    }

}
