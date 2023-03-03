<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |doctorPost
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'Benificary' => [
            'driver' => 'passport',
            'provider' => 'Benificarys',
        ],

        'Doctor' => [
            'driver' => 'passport',
            'provider' => 'Doctors',
        ],

        'guide' => [
            'driver' => 'passport',
            'provider' => 'guides',
        ],

        'doctorPost' => [
            'driver' => 'passport',
            'provider' => 'doctorPosts',
        ],

        'guidePost' => [
            'driver' => 'passport',
            'provider' => 'guidePosts',
        ],


        'ask' => [
            'driver' => 'passport',
            'provider' => 'asks',
        ],


        'answer' => [
            'driver' => 'passport',
            'provider' => 'answers',
        ],


        'answers_guide' => [
            'driver' => 'passport',
            'provider' => 'answers_guides',
        ],

        'doctor_profile' => [
            'driver' => 'passport',
            'provider' => 'doctor_profiles',
        ],


        'guideprofile' => [
            'driver' => 'passport',
            'provider' => 'guideprofiles',
        ],


        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],

    /*ask   answer  doctor_profile   guideprofile
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |doctorPost   answer   doctor_profile
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],



        'Benificarys' => [
            'driver' => 'eloquent',
            'model' => App\Models\Benificary::class,
        ],

        'Doctors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doctor::class,
        ],



        'guides' => [
            'driver' => 'eloquent',
            'model' => App\Models\guide::class,
        ],

        'doctorPosts' => [
            'driver' => 'eloquent',
            'model' => App\Models\doctorPost::class,
        ],

        'guidePosts' => [
            'driver' => 'eloquent',
            'model' => App\Models\guidePost::class,
        ],


        'asks' => [
            'driver' => 'eloquent',
            'model' => App\Models\ask::class,
        ],


        'answers' => [
            'driver' => 'eloquent',
            'model' => App\Models\answer::class,
        ],


        'answers_guides' => [
            'driver' => 'eloquent',
            'model' => App\Models\answers_guide::class,
        ],


        'doctor_profiles' => [
            'driver' => 'eloquent',
            'model' => App\Models\doctor_profile::class,
        ],


        'guideprofiles' => [
            'driver' => 'eloquent',
            'model' => App\Models\guideprofile::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*ask   answer   answers_guide   guideprofile
    |-------guidePost----------------------doctor_profile---------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'Benificarys' => [
            'provider' => 'Benificarys',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'Doctors' => [
            'provider' => 'Doctors',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'guides' => [
            'provider' => 'guides',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'doctorPosts' => [
            'provider' => 'doctorPosts',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'guidePosts' => [
            'provider' => 'guidePosts',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'asks' => [
            'provider' => 'asks',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'answers' => [
            'provider' => 'answers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'answers_guides' => [
            'provider' => 'answers_guides',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


        'doctor_profiles' => [
            'provider' => 'doctor_profiles',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'guideprofiles' => [
            'provider' => 'guideprofiles',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


    ],

    /*guide guidePost ask    answer   answers_guide   doctor_profile  guideprofile
    |-----------------doctorPost---------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
