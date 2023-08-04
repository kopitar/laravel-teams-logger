<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Monolog\Logger;

class TeamsLogger extends Logger
{
    /**
     * @param string $url
     * @param Level $level
     * @param bool $bubble
     */
    public function __construct($url, $level, $bubble = true)
    {
        $name = config('teams_logger.name') ?? 'Teams Logger';
        parent::__construct($name);

        $this->pushHandler(new TeamsLoggerHandler($url, $level, $name, $bubble));
    }
}
