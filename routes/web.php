<?php
use Illuminate\Http\Request;

Route::get('/',function(){
    return '<a href="ed2k://|friend|欢迎加入eMule吧|F4F812C2A70E678FA8F5D01829366F1C|/">ed2k</a>';
});

Route::get('home',['middleware'=>'sso', function(){
    return '登陆的用户id是'.request()->input('uid');
}]);

Route::get('sso/login','Auth\LoginController@getLogin');

Route::post('sso/login','Auth\LoginController@postLogin');

Route::get('sso/logout','Auth\LoginController@postLogout');








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



