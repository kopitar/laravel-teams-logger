<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger\Style;

enum Avatar: string
{
    case EMERGENCY = 'https://api.dicebear.com/6.x/initials/png?seed=EM&radius=6&color=FFFFFF&backgroundColor=d10000&size=40';
    case ALERT = 'https://api.dicebear.com/6.x/initials/png?seed=AL&radius=6&color=FFFFFF&backgroundColor=b80617&size=40';
    case CRITICAL = 'https://api.dicebear.com/6.x/initials/png?seed=CR&radius=6&color=FFFFFF&backgroundColor=ea0000&size=40';
    case ERROR = 'https://api.dicebear.com/6.x/initials/png?seed=ER&radius=6&color=FFFFFF&backgroundColor=FF0000&size=40';
    case WARNING = 'https://api.dicebear.com/6.x/initials/png?seed=WN&radius=6&color=FFFFFF&backgroundColor=e47302&size=40';
    case NOTICE = 'https://api.dicebear.com/6.x/initials/png?seed=NT&radius=6&color=FFFFFF&backgroundColor=3892f5&size=40';
    case INFO = 'https://api.dicebear.com/6.x/initials/png?seed=IN&radius=6&color=FFFFFF&backgroundColor=6ceca9&size=40';
    case DEBUG = 'https://api.dicebear.com/6.x/initials/png?seed=DE&radius=6&color=FFFFFF&backgroundColor=bfc2c0&size=40';

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
     * In case value was changed in config get that value, otherwise return the one defined here
     *
     * @param string $level
     * @return string
     */
    public static function get(string $level): string
    {
        $default = self::fromLevel($level);
        $fromConfig = config('teams_logger.avatars.' . strtolower($level));
        if ($fromConfig && ($default->value != $fromConfig)) {
            return $fromConfig instanceof self ? $fromConfig->value : $fromConfig;
        }
        return $default->value;
    }
}
