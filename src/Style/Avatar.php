<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger\Style;

class Avatar
{
    const EMERGENCY = 'https://api.dicebear.com/6.x/initials/png?seed=EM&radius=6&color=FFFFFF&backgroundColor=d10000&size=40';
    const ALERT = 'https://api.dicebear.com/6.x/initials/png?seed=AL&radius=6&color=FFFFFF&backgroundColor=b80617&size=40';
    const CRITICAL = 'https://api.dicebear.com/6.x/initials/png?seed=CR&radius=6&color=FFFFFF&backgroundColor=ea0000&size=40';
    const ERROR = 'https://api.dicebear.com/6.x/initials/png?seed=ER&radius=6&color=FFFFFF&backgroundColor=FF0000&size=40';
    const WARNING = 'https://api.dicebear.com/6.x/initials/png?seed=WN&radius=6&color=FFFFFF&backgroundColor=e47302&size=40';
    const NOTICE = 'https://api.dicebear.com/6.x/initials/png?seed=NT&radius=6&color=FFFFFF&backgroundColor=3892f5&size=40';
    const INFO = 'https://api.dicebear.com/6.x/initials/png?seed=IN&radius=6&color=FFFFFF&backgroundColor=6ceca9&size=40';
    const DEBUG = 'https://api.dicebear.com/6.x/initials/png?seed=DE&radius=6&color=FFFFFF&backgroundColor=bfc2c0&size=40';

    private $const;

    public function __construct($const = 'DEBUG')
    {
        $this->const = $const;
    }

    /**
     * Get avatar url for a given log level from config or default value
     *
     * @return string
     */
    public function __toString(): string
    {
        return config('teams_logger.avatars.'.strtolower($this->const), constant('self::'.$this->const));
    }
}
