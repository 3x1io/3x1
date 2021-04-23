<?php

namespace Brackets\AdminAuth\Http\Controllers\Auth;

use Brackets\AdminAuth\Http\Controllers\Controller;
use Brackets\AdminAuth\Traits\ResetsPasswords;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Password broker used for admin user
     *
     * @var string
     */
    protected $passwordBroker = 'admin_users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
        $this->passwordBroker = config('admin-auth.defaults.passwords');
        $this->redirectTo = config('admin-auth.password_reset_redirect');
        $this->middleware('guest.admin:' . $this->guard);
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param Request $request
     * @param string|null $token
     * @return Factory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('brackets/admin-auth::admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        if ($this->loginCheck($user)) {
            $this->guard()->login($user);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param Request $request
     * @throws ValidationException
     * @return RedirectResponse|JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param Request $request
     * @param string $response
     * @return RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        $message = trans($response);
        if ($response === Password::PASSWORD_RESET) {
            $message = trans('brackets/admin-auth::admin.passwords.reset');
        }
        return redirect($this->redirectPath())
            ->with('status', $message);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param Request
     * @param string $response
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $message = trans($response);
        if ($response === Password::INVALID_TOKEN) {
            $message = trans('brackets/admin-auth::admin.passwords.invalid_token');
        } else {
            if ($response === Password::INVALID_USER) {
                $message = trans('brackets/admin-auth::admin.passwords.invalid_user');
            } else {
                if ($response === Password::INVALID_PASSWORD) {
                    $message = trans('brackets/admin-auth::admin.passwords.invalid_password');
                }
            }
        }
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $message]);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email|string',
            'password' => 'required|confirmed|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/|string',
        ];
    }

    /**
     * Check if provided user can be logged in
     *
     * @param CanResetPassword $user
     * @return bool
     */
    protected function loginCheck($user): bool
    {
        return ($user->activated === null || $user->activated) && ($user->forbidden === null || !$user->forbidden);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBrokerContract
     */
    public function broker(): ?PasswordBrokerContract
    {
        return Password::broker($this->passwordBroker);
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard);
    }
}
