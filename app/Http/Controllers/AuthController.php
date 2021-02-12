<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    const MAX_ATTEMPTS = 3;

    /**
     * @return Guard|StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('username')) . '_' . str_replace('.', '_', $request->ip());
    }

    /**
     * @return RateLimiter
     */
    protected function limiter(): RateLimiter
    {
        return app(RateLimiter::class);
    }

    /**
     * @param string $throttleKey
     * @return bool
     */
    protected function hasTooManyLoginAttempt(string $throttleKey): bool
    {
        return $this->limiter()->tooManyAttempts($throttleKey, self::MAX_ATTEMPTS);
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout()
    {
        (new Log())->store(auth()->user()->id, 'User logged out', request()->ip());
        auth()->logout();
        return redirect(route('login'));
    }

    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function login(Request $request)
    {
        if (Auth::check())
            return redirect()->route('home');

        /** @var array|string|null $error */
        $error = null;

        try {
            if ($request->isMethod('POST')) {
                /** @var \Illuminate\Validation\Validator $validator */
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'password' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    return redirect()->route('login')->with(
                        'error',
                        $validator->messages()->toArray()
                    );
                }

                if ($this->hasTooManyLoginAttempt($this->throttleKey($request))) {
                    event(new Lockout($request));

                    throw new \RuntimeException(
                        'Too many attempts try after:  ' .
                        $this->limiter()->availableIn($this->throttleKey($request)) .
                        ' секунд'
                    );
                }

                $credentials = [
                    'name' => $request->input('name'),
                    'password' => $request->input('password')
                ];

                if ($this->guard()->attempt($credentials)) {
                    (new Log())->store(auth()->user()->id, 'User logged in', request()->ip());

                    $request->session()->regenerate();
                    return redirect()->route('home');
                }

                $this->limiter()->hit($this->throttleKey($request), 1 * 60);

                $error = 'No matches in our DB';
            }
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
        }

        return view('auth.login', ['error' => $error]);
    }
}
