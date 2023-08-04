<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger\Style;

class Color
{
    const EMERGENCY = 'd10000';
    const ALERT     = 'b80617';
    const CRITICAL  = 'ea0000';
    const ERROR     = 'FF0000';
    const WARNING   = 'e47302';
    const NOTICE    = '3892f5';
    const INFO      = '6ceca9';
    const DEBUG     = 'bfc2c0';

    private $const;

    public function __construct($const = 'DEBUG')
    {
        $this->const = $const;
    }

    /**
     * Get color value for a givn log level from config or default value
     *
     * @return string
     */
    public function __toString(): string
    {
        return '#' . config('teams_logger.colors.' . strtolower($this->const), constant('self::' . $this->const));
    }
}
