<?php

namespace Spinen\Halo\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Spinen\Halo\Api\Client as Halo;

/**
 * Class HaloController
 */
class HaloController extends Controller
{
    /**
     * Process the code returned for the user & save as halo_token
     *
     * @throws GuzzleException
     */
    public function __invoke(Halo $halo, Redirector $redirector, Request $request): RedirectResponse
    {
        $request->user()->halo_token = $halo->oauthRequestTokenUsingAuthorizationCode(
            code: (string) $request->get('code'),
            uri: $request->url(),
            verifier: $request->session()->get('halo_code_verifier'),
        );

        $request->user()->save();

        return $redirector->intended();
    }
}
