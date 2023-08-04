<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger\Style;

enum Color: string
{
    case EMERGENCY = '#d10000';
    case ALERT     = '#b80617';
    case CRITICAL  = '#ea0000';
    case ERROR     = '#FF0000';
    case WARNING   = '#e47302';
    case NOTICE    = '#3892f5';
    case INFO      = '#6ceca9';
    case DEBUG     = '#bfc2c0';

    public const LEVELS = [
        'EMERGENCY',
        'ALERT',
        'CRITICAL',
        'ERROR',
        'WARNING',
        'NOTICE',
        'INFO',
        'DEBUG',
    ];

    /**
     * @param value-of<self::LEVELS>|'Emergency'|'Alert'|'Critical'|'Error'|'Warning'|'Notice'|'Info'|'Debug' $level
     * @return static
     */
    public static function fromLevel(string $level): self
    {
        return match ($level) {
            'emergency', 'Emergency', 'EMERGENCY' => self::EMERGENCY,
            'alert', 'Alert', 'ALERT' => self::ALERT,
            'critical', 'Critical', 'CRITICAL' => self::CRITICAL,
            'error', 'Error', 'ERROR' => self::ERROR,
            'warning', 'Warning', 'WARNING' => self::WARNING,
            'notice', 'Notice', 'NOTICE' => self::NOTICE,
            'info', 'Info', 'INFO' => self::INFO,
            'debug', 'Debug', 'DEBUG' => self::DEBUG
        };
    }

    /**
     * In case value was changed in config get that vallue, otherwise return the one defined here
     *
     * @param string $level
     * @return string
     */
    public static function get(string $level): string
    {
        $default = self::fromLevel($level);
        $fromConfig = config('teams_logger.colors.' . strtolower($level));
        if ($fromConfig && ($default->value != $fromConfig)) {
            return $fromConfig instanceof self ? $fromConfig->value : $fromConfig;
        }
        return $default->value;
    }
}
