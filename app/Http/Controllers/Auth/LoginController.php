<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\Factory as View;
use Illuminate\Routing\UrlGenerator as Url;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * @var \Illuminate\Routing\UrlGenerator
     */
    private $url;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Routing\UrlGenerator $url
     */
    public function __construct(Url $url)
    {
        $this->middleware('guest')->except('logout');
        $this->url = $url;
    }

    /**
     * {@inheritDoc}
     */
    public function showLoginForm(View $view)
    {
        return $view->make('pages.login');
    }

    /**
     * Define redirection routes for auth methods.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return $this->url->route('influencers.list', [], false);
    }
}
