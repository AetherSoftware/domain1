<?php

namespace App\Http\Middleware;

use Closure;


class Sso
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
        $SSOToken = $request->cookie('ssotoken');

        $forwardURL = $request->url();

        if (empty($SSOToken)) {
            return redirect('login')->with('forward', $forwardURL);
        }

        //缓存token-user映射关系,先判断是否支持缓存


        # 向sso验证接口发起token验证请求
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            "http://localhost:8099/authtoken", [
                'timeout' => 5,
                'form_params' => [
                    'ssotoken' => $SSOToken
                ]
            ]
        );
        $return = \GuzzleHttp\json_decode($response->getBody());

        if ($return->status == 'error') {
            return redirect('login')->withErrors(['发生异常请重新登陆']);//!!!!!!!错误提示
        }

        $request->merge(['uid' => $return->data->id]);
        //建立token-user映射关系


        return $next($request);
    }

}
