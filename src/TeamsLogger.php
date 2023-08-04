<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Monolog\Level;
use Monolog\Logger;

class TeamsLogger extends Logger
{
    /**
     * @param string $url
     * @param Level $level
     * @param string $type
     * @param string $name
     * @param bool $bubble
     */
    public function __construct($url, $level, $type, $name, $bubble = true)
    {
        parent::__construct($name);

        $this->pushHandler(new TeamsLoggerHandler($url, $level, $type, $name));
    }
}
