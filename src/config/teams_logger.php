<?php

use Kopitar\LaravelTeamsLogger\Style\Color;
use Kopitar\LaravelTeamsLogger\Style\Avatar;

return [
    /*
    |--------------------------------------------------------------------------
    | Log Type
    |--------------------------------------------------------------------------
    | Sets one of two types of log messages
    | 
    | Allowed value: 'simple' (default) and 'card'
    |
    */    
    'type' => env('TEAMS_LOG_TYPE', 'simple'),

    /*
    |--------------------------------------------------------------------------
    | Webhook POST request retries
    |--------------------------------------------------------------------------
    | Number of retries if request to Teams webhook fails
    | 
    | Allowed value: integer (default: 0)
    |
    */    
    'retries' => env('TEAMS_RETRIES', 0),   

    /*
    |--------------------------------------------------------------------------
    | Use Avatar
    |--------------------------------------------------------------------------
    | Display avatar image in messages of type 'card'
    | 
    | Allowed value: boolean (default: true)
    |
    */    
    'use_avatar' => env('TEAMS_AVATAR', true),   

    /*
    |--------------------------------------------------------------------------
    | Log message colors
    |--------------------------------------------------------------------------
    | Colors for all of the available log levels
    | 
    | Allowed values: hex color codes (example: 721C24)
    |
    */    
    'colors' => [
        'emergency' => env('TEAMS_COLOR_EMERGENCY', Color::EMERGENCY),
        'alert' => env('TEAMS_COLOR_ALERT', Color::ALERT),
        'critical' => env('TEAMS_COLOR_CRITICAL', Color::CRITICAL),
        'error' => env('TEAMS_COLOR_ERROR', Color::ERROR),
        'warning' => env('TEAMS_COLOR_WARNING', Color::WARNING),
        'notice' => env('TEAMS_COLOR_NOTICE', Color::NOTICE),
        'info' => env('TEAMS_COLOR_INFO', Color::INFO),
        'debug' => env('TEAMS_COLOR_DEBUG', Color::DEBUG),
    ],
    /*
    |--------------------------------------------------------------------------
    | Log message avatars
    |--------------------------------------------------------------------------
    | Avatar images for all of the available log levels
    | 
    | Allowed values: URL of avatar image
    |
    */      
    'avatars' => [
        'emergency' => env('TEAMS_AVATAR_EMERGENCY', Avatar::EMERGENCY),
        'alert' => env('TEAMS_AVATAR_ALERT', Avatar::ALERT),
        'critical' => env('TEAMS_AVATAR_CRITICAL', Avatar::CRITICAL),
        'error' => env('TEAMS_AVATAR_ERROR', Avatar::ERROR),
        'warning' => env('TEAMS_AVATAR_WARNING', Avatar::WARNING),
        'notice' => env('TEAMS_AVATAR_NOTICE', Avatar::NOTICE),
        'info' => env('TEAMS_AVATAR_INFO', Avatar::INFO),
        'debug' => env('TEAMS_AVATAR_DEBUG', Avatar::DEBUG),
    ]        
];