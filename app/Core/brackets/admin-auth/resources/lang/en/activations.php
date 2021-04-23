<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Activation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the activation broker for a account activation attempt
    | has failed, such as for an invalid token or invalid user.
    |
    */

    'sent' => 'We have sent you an activation link!',
    'activated' => 'Your account was activated!',
    'token' => 'The activation token is invalid.',
    'user' => "We can't find a user with submitted credentials. User might be already activated.",
    'disabled' => 'Activation is disabled.',

    'email' => [
        'line' => 'You are receiving this email because we received an activation request for your account.',
        'action' => 'Activate your account',
        'notRequested' => 'If you did not request an activation, no further action is required.',
    ],

];
