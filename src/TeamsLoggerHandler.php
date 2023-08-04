<?php

declare(strict_types=1);

namespace Kopitar\LaravelTeamsLogger;

use Kopitar\LaravelTeamsLogger\Style\Avatar;
use Kopitar\LaravelTeamsLogger\Style\Color;
use Kopitar\LaravelTeamsLogger\TeamsMessage;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\Curl\Util;
use Monolog\LogRecord;

class TeamsLoggerHandler extends AbstractProcessingHandler
{
    public function __construct($url, $level, $name, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Return a json encoded message to be sent depending on incoming data
     *
     * @param LogRecord $record
     * @return string
     */
    public function makeMessage(LogRecord $record): string
    {
        $data = (array) $record;

        if (!array_key_exists('type', $data['context'])) {
            $data['context']['type'] = config('teams_logger.type') ?? 'simple';
        }

        $message = new TeamsMessage(
            $data['context']['type'],
            $this->name
        );

        return $message->build($data);
    }

    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        $message = $this->makeMessage($record);

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: '.strlen($message),
        ]);

        $tries = 1;
        $retries = config('teams_logger.retries');

        if (is_numeric($retries) && $retries > 0) {
            $tries += (int) $retries;
        }

        Util::execute(
            $ch,
            $tries,
            false
        );
    }
}
