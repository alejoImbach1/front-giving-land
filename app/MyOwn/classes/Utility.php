<?php
namespace App\MyOwn\classes;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Utility
{
    public static function viewAlert(string $type,string $message){
        session()->flash('alert',[
            'type' => $type,
            'message' => $message
        ]);
    }

    public static function sendVerificationCode(string $email): string
    {
        $permitted_chars = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 6);
        session(['plain' => $code]);
        // Mail::to($email)->send(new ValidationMailable($code));
        return Hash::make($code);
    }

    public static function generateUsername(string $name): string
    {
        $username = Str::slug($name);
        $originalUsername = $username;

        // Verificar si el nombre de usuario ya existe en la base de datos
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public static function getLocationData(){
        return DB::table('departamentos_municipios')->get();
    }
}
