<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('authentications.login');
    }

    public function store(LoginRequest $request)
    {
        $validatedData = $request->validated();

        if (Auth::attempt([
            "email" => $validatedData['email'],
            "password" => $validatedData['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home.index');
        }

        return back()
            ->with(['error' => __('auth.failed')])
            ->onlyInput('email');
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

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.index');
    }
}
