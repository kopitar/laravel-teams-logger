<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Monolog\Level;

class TeamsLoggerFactory
{
    public function __invoke(array $config): TeamsLogger
    {
        return new TeamsLogger($config['url'], $config['level'] ?? Level::Debug);
    }
}
