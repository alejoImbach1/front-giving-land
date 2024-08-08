<?php

namespace App\Http\Controllers;

use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SecurityPrivacyController extends Controller
{
    public function index()
    {
        $user = Http::authtoken()->get('/users/' . session('auth_user')['id'], [
            'included' => 'profile.image'
        ])->json();
           
        $profileImageUrl = Utility::getAuthProfileImageUrl($user['profile']);
        return view('sections.security-privacy.index',compact('profileImageUrl'));
    }
    
    public function accountDeletion()
    {
        return view('sections.security-privacy.account-deletion-form');
    }
}
