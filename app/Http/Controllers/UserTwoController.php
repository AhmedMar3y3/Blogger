<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTwoController extends Controller
{
    public function home(){
        return view('User.home-page');
    }
    public function contactPage(){
        return view('User.contact-page');
    }
    public function registerUser(){
        return view('User.register');
    }
    public function loginUser(){
        return view('User.login');
    }
    public function faq(){
        return view('User.faq');
    }
}
