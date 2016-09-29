<?php

Route::get('/',function(){
    return 'root';
});

Route::get('home',['middleware'=>'sso', function(\Illuminate\Http\Request $request){
    return '登陆的用户id是'.$request->input('uid');
}]);

Route::get('login',function(){
    return view('login');
});

Route::post('login',function(){

    $email = Request::input('email');
    $password = Request::input('password');
    $forwardURL = Request::input('forward');
    //需要过滤!!!!!!!!
/*
    $this->validate(request(), [
        'passaword' => 'required',
        'email' => 'required|email|unique:users'
    ]);
   */

    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        "http://localhost:8099/authlogin", [
            'timeout' => 5,
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]
    );
    $return = \GuzzleHttp\json_decode($response->getBody());

    if($return->status == 'error'){
        return back()->withErrors(['aa'=>'aaaa']);//!!!!!!!!!!!!!!!!!返回错误信息
    }

    //!!!!!!!!cookie加密
//!!!!!!!!!token需要设定过期时间
    return redirect($forwardURL)->withCookie(Cookie::forever('ssotoken',$return->data,null,'.site.com'));
});








/*
Route::group([],function(){
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout');

    $this->get('register', 'Auth\RegisterController@getRegister');
    $this->post('register', 'Auth\RegisterController@postRegister');

    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});
*/
/*
Route::get('/timestamp',function(){
    return time();
});

Route::get('/{param}',function($param){
    if(strlen($param)==19){
        if(substr($param,0,9)=='timestamp'){
            $gap = time() - substr($param,9,10);
            if($gap > 0 && $gap < 30){
                return 'is admin';
            }

        }
    }
    abort(404);
    return false;
});
*/



