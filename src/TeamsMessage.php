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
     * @param array $record
     * @return string
     * @throws \ValueError
     */
    public function build(array $record): string
    {
        $context = $this->checkLogRecordContextData($record['context']);

        if ($this->type === 'simple') {
            return json_encode([
                'text' => $record['message'],
                'themeColor' => $context['themeColor'] ?? Color::get($record['level']->name)
            ]);
        } elseif ($this->type === 'card') {
            $message = [
                '@type' => 'MessageCard',
                '@context' => 'http://schema.org/extensions',
                'themeColor' => $context['themeColor'] ?? Color::get($record['level']->name),
                'summary' => $record['channel'],
                'sections' => [
                    [
                        'activityTitle' => $context['title'],
                        'activitySubTitle' => $record['message'],
                        'activityImage' => $context['useAvatar'] ? Avatar::get($record['level']->name) : null,
                        'facts' =>  $context['facts'],
                        'markdown' => $context['useMarkdown'],
                    ],
                ],
                'potentialAction' => $context['actions']
            ];
            return json_encode($message);
        } elseif ($this->type === 'json') {
            return $record['message'];
        }
        throw new \ValueError('type argument must be one of: simple, card, json');
    }

    /**
     * Check LogRecord context for facts, actions and any overriden config values
     *
     * @param array $context
     * @return array
     */
    private function checkLogRecordContextData(array $context): array
    {
        $data = [
            'themeColor' => $context['themeColor'] ?? null,
            'title' => $context['title'] ?? $this->name,
            'actions' => $context['actions'] ?? [],
            'useAvatar' => config('teams_logger.use_avatar'),
            'useMarkdown' => config('teams_logger.use_markdown'),
            'facts' => [],
        ];

        // check if use_avatar config is overriden
        if(array_key_exists('avatar', $context) && is_bool($context['avatar'])) {
            $data['useAvatar'] = $context['avatar'];
        }

        // check if use_markdown config is overriden
        if(array_key_exists('markdown', $context) && is_bool($context['markdown'])) {
            $data['useMarkdown'] = $context['markdown'];
        }

        // get facts if any and build facts array
        $facts = $context['facts'] ?? [];
        $factsArr = [];

        foreach ($facts as $name => $value) {
            $factsArr[] = [
                'name' => ucfirst((string) $name),
                'value' => (string) $value,
            ];
        }
        $data['facts'] = $factsArr;

        return $data;
    }
}
