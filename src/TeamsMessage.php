<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Kopitar\LaravelTeamsLogger\Style\Avatar;
use Kopitar\LaravelTeamsLogger\Style\Color;
use Monolog\LogRecord;

class TeamsMessage
{
    private string $type;

    private string $name;

    public function __construct(string $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * Builds data to be sent to Teams incoming webhook
     *
     * @param LogRecord $record
     * @return array
     */
    public function build(LogRecord $record): array
    {
        if ($this->type === 'simple') {
            return [
                'text' => $record['message'],
                'themeColor' => (string) new Color($record['level_name']),
            ];
        } elseif ($this->type === 'card') {
            $facts = $record['context']['facts'] ?? [];
            $factsArr = [];

            foreach ($facts as $name => $value) {
                $factsArr[] = [
                    'name' => ucfirst((string) $name),
                    'value' => (string) $value,
                ];
            }
            $message = [
                '@type' => 'MessageCard',
                '@context' => 'http://schema.org/extensions',
                'themeColor' => (string) new Color($record['level_name']),
                'summary' => $record['channel'],
                'sections' => [[
                    'activitySubTitle' => $record['message'],
                    'activityTitle' => $this->name,
                    'activityImage' => config('teams_logger.use_avatar') ? (string) new Avatar($record['level_name']) : null,
                    'facts' =>  $factsArr,
                    'markdown' => true,
                ]],
            ];

            return $message;
        }
        throw new \ValueError('type argument must be one of: simple, card');
    }
}
