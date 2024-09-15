<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'mail' => [
        'description' => "Thanks for signing up! \nBefore getting started, could you verify your email address by clicking on the link we just emailed to you?\n If you didn't receive the email, we will gladly send you another.",
		'link-resent' => 'A new verification link has been sent to your :email email address',
    ],
    'register-title' => 'Register',
    'login-title' => 'Login',
    'not-account' => ['You don\'t have an account ?', 'Sign Up'],
    'already-account' => ['Do you already have an account ?', 'Sign In'],
    'label' => [
        'name' => 'Name',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'sex' => [
            'main' => 'Sex',
            'male' => 'Male',
            'female' => 'Female',
        ],
        'username' => 'Username',
        'email' => 'Email',
        'email_or_username' => 'Email or username',
        'password' => [
            'main' => 'Password',
            'confirm' => 'Confirm Password',
        ],
    ],
    'button' => [
        'google' => 'Continue with Google',
        'login' => 'Log in',
        'register' => 'Sign Up',
    ],

];
