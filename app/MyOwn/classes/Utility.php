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

    public static function checkAuth(): bool
    {
        return session()->has('auth_token');
    }

}
