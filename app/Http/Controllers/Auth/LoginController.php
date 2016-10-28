<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Cookie;

class LoginController extends Controller
{
    protected $redirectURL = "/";

    function getLogin(){
        return view('login');
    }

    function postLogin(Request $request){

        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required',
            'forward' => 'bail|present'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $forwardURL = $request->input('forward');
        $sso_clientip = $request->getClientIp();
        $sso_useragent = $request->header('user-agent');
        //$sso_expire = time() + 60;
        $forwardURL == ''?:$this->redirectURL;
        # 向验证服务器提交验证请求
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                Config::get('sso.domain') . "/auth/login", [
                    'timeout' => 5,
                    'form_params' => [
                        'email' => $email,
                        'password' => $password
                    ]
                ]
            );
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return back()->withErrors(['验证过程出错，无法进行验证。']);
        }

        $return = \GuzzleHttp\json_decode($response->getBody());

        if($return->status != 'success'){
            return back()->withErrors(['操作失败，'.$return->message.'。']);
        }

        $sso_token = $return->data->ssotoken;

        $cookieContent = json_encode(compact('sso_token','sso_clientip','sso_useragent'));

        return redirect($forwardURL)->withCookie(Cookie::forever('sso',$cookieContent,null,'.site.com'));
    }

    function postLogout(Request $request){

        $cookie_sso = $request->cookie('sso');
        $SSO = json_decode($cookie_sso);
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                Config::get('sso.domain') . "/auth/logout", [
                    'timeout' => 5,
                    'form_params' => [
                        'ssotoken' => $SSO->sso_token,
                    ]
                ]
            );
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return '登出过程出错，无法进行登出。';
        }
        $return = \GuzzleHttp\json_decode($response->getBody());
        if($return->status != 'success'){
            return '操作失败，'.$return->message.'。';
        }

        return redirect('sso/login')->withCookie(Cookie::forget('sso',null,'.site.com'));
    }



}
