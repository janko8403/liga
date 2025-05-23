<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class AutoLogout
{
    protected $session;
    protected $timeout = 900;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $is_logged_in = $request->path() != 'backend/logout';

        if(!session('last_active')) {
            $this->session->put('last_active', time());
        } elseif(time() - $this->session->get('last_active') > $this->timeout) {

            $this->session->forget('last_active');
            $cookie = cookie('intend', $is_logged_in ? url()->current() : '/');
            auth("admin")->logout();
        }

        $is_logged_in ? $this->session->put('last_active', time()) : $this->session->forget('last_active');

        return $next($request);
    }
}
