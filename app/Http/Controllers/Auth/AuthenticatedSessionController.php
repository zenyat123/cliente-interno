<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Traits\Token;

class AuthenticatedSessionController extends Controller
{

    use Token;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
    /*
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    */

        $request->validate([

            "email" => "required|email",
            "password" => "required|min:8"

        ]);

        $response = Http::withHeaders([

            "Accept" => "application/json"

        ])->post("http://integrar.pro/api/login", [

            "email" => $request->email,
            "password" => $request->password

        ]);

        if($response->status() == 404)
        {

            return back()->withErrors("These credentials do not match our records");

        }

        $service = $response->json();

        $user = User::updateOrcreate(["email" => $request->email], $service["data"]);

        if(!$user->token)
        {

            $this->getToken($user, $service);

        }

        Auth::login($user, $request->remember);

        $this->refreshToken();

        return redirect()->intended(RouteServiceProvider::HOME);

    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
