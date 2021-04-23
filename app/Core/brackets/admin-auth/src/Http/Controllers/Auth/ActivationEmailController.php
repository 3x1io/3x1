<?php

namespace Brackets\AdminAuth\Http\Controllers\Auth;

use Brackets\AdminAuth\Activation\Contracts\ActivationBroker as ActivationBrokerContract;
use Brackets\AdminAuth\Activation\Facades\Activation;
use Brackets\AdminAuth\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ActivationEmailController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Activation Email Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling activation emails and
    | assists in sending these notifications from
    | your application to your users.
    |
    */

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Activation broker used for admin user
     *
     * @var string
     */
    protected $activationBroker = 'admin_users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
        $this->activationBroker = config('admin-auth.defaults.activations');
        $this->middleware('guest.admin:' . $this->guard);
    }

    /**
     * Display the form to request a activation link.
     *
     * @return Response
     */
    public function showLinkRequestForm()
    {
        if (config('admin-auth.self_activation_form_enabled')) {
            return view('brackets/admin-auth::admin.auth.activation.email');
        } else {
            abort(404);
        }
    }

    /**
     * Send an activation link to the given user.
     *
     * @param Request $request
     * @throws ValidationException
     * @return RedirectResponse|Response
     */
    public function sendActivationEmail(Request $request)
    {
        if (config('admin-auth.self_activation_form_enabled')) {
            if (!config('admin-auth.activation_enabled')) {
                return $this->sendActivationLinkFailedResponse($request, Activation::ACTIVATION_DISABLED);
            }

            $this->validateEmail($request);

            // We will send the activation link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendActivationLink(
                $this->credentials($request)
            );

            return $this->sendActivationLinkResponse($request, $response);
        } else {
            abort(404);
        }
    }

    /**
     * Validate the email for the given request.
     *
     * @param Request $request
     * @throws ValidationException
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Get the response for a successful activation link.
     *
     * @param Request $request
     * @param string $response
     * @return RedirectResponse
     */
    protected function sendActivationLinkResponse(Request $request, $response)
    {
        $message = trans('brackets/admin-auth::admin.activations.sent');
        return back()->with('status', $message);
    }

    /**
     * Get the response for a failed activation link.
     *
     * @param Request
     * @param string $response
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendActivationLinkFailedResponse(Request $request, $response)
    {
        $message = trans($response);
        if ($response === Activation::ACTIVATION_DISABLED) {
            $message = trans('brackets/admin-auth::admin.activations.disabled');
        }
        return back()->withErrors(
            ['email' => $message]
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        $conditions = ['activated' => false];
        return array_merge($request->only('email'), $conditions);
    }

    /**
     * Get the broker to be used during activation.
     *
     * @return ActivationBrokerContract
     */
    public function broker(): ?ActivationBrokerContract
    {
        return Activation::broker($this->activationBroker);
    }
}
