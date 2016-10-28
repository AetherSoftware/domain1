<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class SSO
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

        $cookie_sso = $request->cookie('sso');
        $clientIp = $request->getClientIp();
        $userAgent = $request->header('user-agent');
        $forwardURL = $request->url();

        $SSO = json_decode($cookie_sso);

        if (empty($SSO->sso_token)||$SSO->sso_clientip != $clientIp||$SSO->sso_useragent != $userAgent) {
            return redirect('sso/login')->with('forward', $forwardURL);
        }

        # 向sso验证接口发起token验证请求
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                Config::get('sso.domain') . "/auth/token", [
                    'timeout' => 5,
                    'form_params' => [
                        'ssotoken' => $SSO->sso_token
                    ]
                ]
            );
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return back()->withErrors(['验证过程出错，无法进行验证。']);
        }

        $return = \GuzzleHttp\json_decode($response->getBody());

        if ($return->status != 'success') {
            return redirect('sso/login')->with('forward', $forwardURL)->withErrors([$return->message.'，请重新登录。']);
        }

        $request->merge(['uid' => $return->data->id]);



        return $next($request);
    }

}
