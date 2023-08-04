# laravel-teams-logger

Log handler for Laravel for sending log messages to Microsoft Teams with the  [Teams Incoming Webhook Connector](https://learn.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook?tabs=dotnet).


## Features

* send simple messages  
* send card messages
* configurable colors for all log levels
* configurable avatars for all log levels

## Installation

Require this package with composer.

```bash
$ composer require kopitar/laravel-teams-logger
```

## Configuration


After installing the package using composer, create a new [custom channel](https://laravel.com/docs/master/logging#creating-custom-channels-via-factories) in `config/logging.php`:

```php
'teams' => [
    'driver'  => 'custom',
    'via'     => \Kopitar\LaravelTeamsLogger\TeamsLoggerFactory::class,
    'level'   => 'debug',
    'url'     => env('TEAMS_WEBHOOK_URL'),
    'type'    => env('TEAMS_LOG_TYPE', 'simple'),
    'name'    => env('APP_NAME', 'Teams logger'),
],
```


Copy `teams_logger` config file from laravel-teams-logger to your Laravel config folder with the following command:

```bash
$ php artisan vendor:publish --tag=teams
```

There are 2 available styles for microsoft teams message, using simple and card. You can see card style in results style which is difference from simple style.
Add 

Add `TEAMS_WEBHOOK_URL` variable to your `.env` file with the URL provided by your Microsoft Teams Connector. (See  [MS Teams Documentation](https://learn.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook?tabs=dotnet#create-incoming-webhooks-1) for more information on where to get your webhook URL).

Other `.env` variables for this package that are optional and all have defualt values can be found in [`config/teams_logger.php`](src/config/teams_logger.php).
These optional `.env` variables provide a way for you to change colors, avatars, number of retries, etc.


## Usage

To send a simple error message to teams channel use the following code:

```php
Log::channel('teams')->info('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet...');
```

You can always override your message `type` setting with an additional parameter for whenever you want to send a message type different from the one in config:

```php
Log::channel('teams')->info(
    'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet...',
    ['type' => 'card']
    );
```
**Result:**

![Screenshot](https://github.com/kopitar/laravel-teams-logger/raw/main/images/simple_info.png?raw=true)


When using '*card*' type you can also pass a `facts` parameter which needs to be an array. The contents of this array are then rendered as a *key:value* list in the card message.

```php
Log::channel('teams')->notice(
    'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet...',
    [
        'type' => 'card',
        'facts' => [
            'happened at' => now()->toDayDateTimeString(),
            'file' => __FILE__
        ],
    ]
    );
```
**Result:**

![Screenshot](https://github.com/kopitar/laravel-teams-logger/raw/main/images/card_facts.png?raw=true)


## Preview
...

## License

This laravel-teams-logging package is available under the MIT license. See [LICENSE.md](LICENSE.md) file for more info.