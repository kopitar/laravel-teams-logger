<?php

use Kopitar\LaravelTeamsLogger\Style\Color;
use Kopitar\LaravelTeamsLogger\Style\Avatar;

return [
    /*
    |--------------------------------------------------------------------------
    | Log Name
    |--------------------------------------------------------------------------
    | Name of logger, also used as title/summary in messages of type 'card'
    |
    | Allowed value: string (default: Teams Logger)
    |
    */
    'name' => env('TEAMS_LOG_NAME', 'Teams Logger'),

    /*
    |--------------------------------------------------------------------------
    | Log Type
    |--------------------------------------------------------------------------
    | Sets one of three types of log messages
    |
    | Allowed value: 'simple' (default), 'card' and 'json'
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
    | Use markdown
    |--------------------------------------------------------------------------
    | Disable or enable markdown in messages
    |
    | Allowed value: boolean (default: true)
    |
    */
    'use_markdown' => env('TEAMS_MARKDOWN', true),

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
    | Allowed values: hex color codes (example: #721C24)
    |
    */
    'colors' => [
        'emergency' => Color::fromLevel('EMERGENCY'),
        'alert' => Color::fromLevel('ALERT'),
        'critical' => Color::fromLevel('CRITICAL'),
        'error' => Color::fromLevel('ERROR'),
        'warning' => Color::fromLevel('WARNING'),
        'notice' => Color::fromLevel('NOTICE'),
        'info' => Color::fromLevel('INFO'),
        'debug' => Color::fromLevel('DEBUG'),
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
        'emergency' => Avatar::fromLevel('EMERGENCY'),
        'alert' => Avatar::fromLevel('ALERT'),
        'critical' => Avatar::fromLevel('CRITICAL'),
        'error' => Avatar::fromLevel('ERROR'),
        'warning' => Avatar::fromLevel('WARNING'),
        'notice' => Avatar::fromLevel('NOTICE'),
        'info' => Avatar::fromLevel('INFO'),
        'debug' => Avatar::fromLevel('DEBUG'),
    ]
];
