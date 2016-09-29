<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Response;
class SuperviseRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(self::registrationIsForbidden()){
            return new Response(view('notice.easy')->with('message','目前不提供注册服务。'));
        }

        if(self::registrationRequiresInvitation()){

            if(!($request->has('invite_code'))){
                return new Response(view('auth.invite'));
            }

            if(self::inviteCodeIsInvalid($request->input('invite_code'))){
                return back()->with('status', '无效的邀请码。');
            }
        }

        return $next($request);
    }

    protected function registrationIsForbidden()
    {
        if(!env('REGISTRATION_IS_ALLOWED')){
            return true;
        }
        return false;
    }

    protected function registrationRequiresInvitation()
    {
        if(env('REGISTRATION_REQUIRES_INVITATION')){
            return true;
        }
        return false;
    }

    protected function inviteCodeIsInvalid($invite_code)
    {
        $invite_code_exist = DB::table('invites')->where('code',$invite_code)->first();

        if(!$invite_code_exist){
            return true;
        }
        return false;
    }
}
