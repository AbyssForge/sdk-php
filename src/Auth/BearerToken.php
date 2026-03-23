<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Auth;

use AbyssForge\Configuration;

final class BearerToken
{
    private function __construct()
    {
    }

    /**
     * Returns a new generated SDK Configuration instance with OAuth2 bearer token set.
     */
    public static function configuration(string $token): Configuration
    {
        $configuration = Configuration::getDefaultConfiguration();
        $configuration->setAccessToken($token);

        return $configuration;
    }

    /**
     * Applies a bearer token to an existing generated SDK Configuration.
     */
    public static function apply(Configuration $configuration, string $token): Configuration
    {
        $configuration->setAccessToken($token);

        return $configuration;
    }
}
