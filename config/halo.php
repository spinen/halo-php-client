<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Halo OAuth
    |--------------------------------------------------------------------------
    |
    | ID & secret to make OAuth requests per authorization type.  There are two
    | supported grant types: 1) authorization_code & 2) client_credentials.
    | You can use one or both of them.  If you are interacting with Halo on
    | behalf of your users, then you will want to use authorization_code as it
    | allows your users to generate an API for them that is save on "halo_token"
    | property on the user.  You can protect any routes that need to ensure the
    | user has linked the account with the "halo" middleware.  If you are
    | interacting with HALO as a service, then you will want to use
    | client_credentials.
    |
    */

    'oauth' => [

        /*
        |--------------------------------------------------------------------------
        | Authorization Server (OAUTH URL)
        |--------------------------------------------------------------------------
        |
        | The URL to the Halo authorization server
        |
        */

        'authorization_server' => env('HALO_AUTHORIZATION_SERVER'),

        /*
        |--------------------------------------------------------------------------
        | Authorization Code Authentication
        |--------------------------------------------------------------------------
        |
        | Used mainly by Native Applications. It involves re-directing users from the
        | client application to the Halo Authentication Server with the Applications
        | Client ID, and redirect URI as parameters.
        |
        */

        'authorization_code' => [

            'id' => env('HALO_AUTHORIZATION_CODE_CLIENT_ID', null),

            /*
            |--------------------------------------------------------------------------
            | Use/Require Proof Key for Code Exchange (PKCE)
            |--------------------------------------------------------------------------
            |
            | To add additional security to the code exchange and prevent the code
            | from being stolen and used elsewhere.
            |
            | default: true in code
            |
            */

            'pkce' => true, // Strongly recommended to be true

            /*
            |--------------------------------------------------------------------------
            | Route for authorization code redirect
            |--------------------------------------------------------------------------
            |
            | The trailing slash is removed from the URI, so make sure that you leave
            | it off when adding the redirect_uri to the API configuration.
            |
            */

            'route' => [
                'enabled' => true,

                'middleware' => ['web'],

                // TODO: Change this key to something like "redirect_to" or "grant" or "code" or "uri"
                'sso' => 'halo/sso',
            ],

        ],

        /*
        |--------------------------------------------------------------------------
        | Client Credentials Authentication
        |--------------------------------------------------------------------------
        |
        | Used mainly by background services where a user has no input
        |
        */

        'client_credentials' => [

            'id' => env('HALO_CLIENT_CREDENTIALS_CLIENT_ID', null),

            'secret' => env('HALO_CLIENT_CREDENTIALS_CLIENT_SECRET', null),

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Server (API URL)
    |--------------------------------------------------------------------------
    |
    | The URL to the Halo resource server
    |
    */

    'resource_server' => env('HALO_RESOURCE_SERVER'),

    /*
    |--------------------------------------------------------------------------
    | Optional Tenant
    |--------------------------------------------------------------------------
    |
    | Tenant from Config > Integrations > Halo API
    |
    */

    'tenant' => env('HALO_TENANT', null),

];
