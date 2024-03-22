<?php

namespace App\Helpers;

class SocialLoginHelper
{
    public static function handleLoginError($error)
    {
        // Logic to handle social login errors based on the error type
        switch ($error) {
            case 'invalid_credentials':
                return 'Invalid credentials. Please try again.';
            case 'account_disabled':
                return 'Your account has been disabled.';
            // Add more cases as needed for different error types
            default:
                return 'An error occurred during social login.';
        }
    }
}
