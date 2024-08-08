<?php

namespace App\Http\Controllers;

use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('sections.forgot-password.index');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $response = Http::backapi()->post('forgot-password', $request->only('email'));

        $responseObject = $response->object();

        $message = $responseObject->message;

        if($response->failed()){
            return back()->withErrors(['email' => $message]);
        }

        return view('reset-password-test',['url' => $responseObject->reset_url]);

        Utility::viewAlert('success', $message);

        return to_route('login');
    }

    public function newPasswordForm(Request $request)
    {
        return view('sections.forgot-password.new-password-form',compact('request'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|regex:/^(?=.*\d).{6,14}$/'
        ]);

        $response = Http::backapi()->post('/reset-password',$request->all());

        Utility::viewAlert($response->successful() ? 'success' : 'warning', $response->object()->message);

        return to_route('login');
    }
}
