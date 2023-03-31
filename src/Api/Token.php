<?php

namespace Spinen\Halo\Api;

use Carbon\Carbon;

class Token
{
    // TODO: Is this a good length?
    public const EXPIRE_BUFFER = 5;

    public Carbon $expires_at;

    // TODO: Should scope be an array? An enum?
    // 'all',
    // 'email',
    // 'offline_access',
    // 'openid',
    // 'profile',
    // 'roles',

    public function __construct(
        public ?string $access_token = null,
        protected int $expires_in = 3600,
        public ?string $id_token = null,
        public ?string $refresh_token = null,
        public string $scope = 'all',
        public string $token_type = 'Bearer',
        public ?string $grant_type = null,
    ) {
        $this->expires_at = Carbon::now()->addSeconds($expires_in);
    }

    public function __toString(): string
    {
        return $this->token_type.' '.$this->access_token;
    }

    /**
     * Check to see if the scope is in the list of scopes for the token
     */
    public function allowedScope(string $scope): bool
    {
        return in_array(
            haystack: explode(separator: ' ', string: $this->scope ?? ''),
            needle: $scope,
        );
    }

    /**
     * If there is a token, has it expired
     */
    public function isExpired(): bool
    {
        return is_null($this->access_token)
            ? false
            : $this->validFor() <= self::EXPIRE_BUFFER;
    }

    /**
     * If there is a token & it has not expired & if provided a scope,
     * check to see if it is allowed scope
     */
    public function isValid(?string $scope = null): bool
    {
        return ! is_null($this->access_token) &&
            ! $this->isExpired() &&
            ($scope ? $this->allowedScope($scope) : true);
    }

    /**
     * If there is a refresh token & the token expires within the BUFFER
     */
    public function needsRefreshing(): bool
    {
        return is_null($this->refresh_token)
            ? false
            : $this->validFor() <= self::EXPIRE_BUFFER;
    }

    /**
     * If there is a token, how many seconds is left before expires
     */
    public function validFor(): int
    {
        return is_null($this->access_token) || Carbon::now()->gte($this->expires_at)
            ? 0
            : $this->expires_at?->diffInSeconds();
    }
}
