<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('sso');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '这就是home路由对应的页面！';
        //$response = Response::make('Hello World');
        //return $response->withCookie(Cookie::forever('token', '123'));
    }

    public function setCookie(){

        return response('Hello World')->cookie(
            'token', '123'
        );
    }
}
