<?php

namespace Spinen\Halo\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Spinen\Halo\Api\Client as Halo;

/**
 * Class Filter
 */
class Filter
{
    /**
     * Create a new Halo filter middleware instance.
     */
    public function __construct(
        protected Halo $halo,
        protected Redirector $redirector,
        protected UrlGenerator $url_generator
    ) {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->halo_token) {
            // Set intended route, so that after linking account, user is put where they were going
            $this->redirector->setIntendedUrl($request->path());

            // Keys will be null if not enabled
            $pkce = $this->halo->generateProofKey();

            $request->session()->flash('halo_code_verifier', $pkce['verifier'] ?? null);

            return $this->redirector->to(
                $this->halo->oauthUri(
                    challenge: $pkce['challenge'] ?? null,
                    uri: (string) $this->url_generator->route('halo.sso.redirect_uri'),
                )
            );
        }

        return $next($request);
    }
}
