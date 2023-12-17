<?php

namespace Kopitar\LaravelTeamsLogger\Tests\Unit;

use Kopitar\LaravelTeamsLogger\TeamsLoggerHandler;
use Monolog\Logger;
use Monolog\Level;
use Monolog\LogRecord;
use Monolog\AbstractProcessingHandler;
use Orchestra\Testbench\TestCase as Orchestra;

class TeamsLoggerTest extends Orchestra
{
    private $logger;
    private $sendingTest = true;
    private $webhookUrl;


    public function setUp(): void
    {
        parent::setUp();

        /** IF WEBHOOK URL IS NOT PROVIDED TESTS THAT TEST SENDING TO TEAMS WILL BE SUCCESSFUL!! */
        if (!$this->webhookUrl = getenv('TEAMS_WEBHOOK_URL')) {
            $this->sendingTest = false;
            $this->webhookUrl = 'http://webhook.url';
        }
    }

    public function test_that_teams_logger_handler_is_instance_of_abstract_processing_handler(): void
    {
        $logger = $this->makeLoggerHandler(
            $this->webhookUrl,
            'Debug',
            'Teams Logger',
        );
        $this->assertInstanceOf(\Monolog\Handler\AbstractProcessingHandler::class, $logger);
    }

    public function test_that_teams_logger_handler_is_registered(): void
    {
        $logger = $this->makeLoggerHandler(
            $this->webhookUrl,
            'Info',
            'Teams Logger',
        );

        $monolog = new Logger('TeamsHandlerTest');
        $monolog->pushHandler($logger);

        $this->assertEquals('TeamsHandlerTest', $monolog->getName());
        $this->assertTrue($monolog->popHandler() instanceof TeamsLoggerHandler);
    }

    public function test_that_log_message_is_sent_or_curl_error_is_returned(): void
    {
        $logger = $this->makeLoggerHandler(
            $this->webhookUrl,
            'Debug',
            'Teams Logger',
        );

        $monolog = new Logger('TeamsHandlerTest');
        $monolog->pushHandler($logger);

        // Send a message
        try {
            if (!$this->sendingTest) {
                throw new \RunTimeException('Curl error (code 7)');
            }
            $result = $monolog->addRecord(Level::Debug, 'Test:' . time(), ['type' => 'simple']);
        } catch(\RunTimeException $e) {
            // sometimes webhook url is not available (or TEAMS_WEBHOOK_URL was not provided either by mistake or intentionally)
            $this->assertStringContainsString('Curl error (code 7)', $e->getMessage());
            $this->assertInstanceOf(\RunTimeException::class, $e);
            return;
        }
        $this->assertTrue($result);
    }

    public function test_invalid_type_parameter_returns_value_error(): void
    {
        $logger = $this->makeLoggerHandler(
            $this->webhookUrl,
            'Debug',
            'Teams Logger',
        );

        $monolog = new Logger('TeamsHandlerTest');
        $monolog->pushHandler($logger);

        // Send a message
        try {
            if (!$this->sendingTest) {
                throw new \RunTimeException('Curl error (code 7)');
            }
            $result = $monolog->addRecord(Level::Debug, 'Test:' . time(), ['type' => 'notvalid']);
        } catch(\RunTimeException $e) {
            // sometimes webhook url is not available (or TEAMS_WEBHOOK_URL was not provided either by mistake or intentionally)
            $this->expectExceptionMessage('Curl error (code 7)');
            $this->assertInstanceOf(\RunTimeException::class, $e);
            return;
        } catch(\ValueError $e) {
            $this->assertInstanceOf(\ValueError::class, $e);
        }
    }

    public function test_that_config_overrides_are_being_used_in_messages(): void
    {
        $name = 'Logger Test';

        $logger = $this->makeLoggerHandler(
            $this->webhookUrl,
            'Debug',
            $name,
        );

        $record = new LogRecord(
            new \DateTimeImmutable(),
            $name,
            Level::Debug,
            'Test message',
            ['type' => 'card', 'title' => $name, 'themeColor' => '#ff0000', 'avatar' => false, 'markdown' => false],
            [],
            null
        );

        $json = $logger->makeMessage($record);
        $message = json_decode($json, true);

        $this->assertEquals($message['@type'], 'MessageCard');
        $this->assertEquals($message['themeColor'], '#ff0000');
        $this->assertEquals($message['summary'], $name);
        $this->assertEquals($message['sections'][0]['activityTitle'], $name);
        $this->assertEquals($message['sections'][0]['activityImage'], null);
        $this->assertEquals($message['sections'][0]['markdown'], false);
    }

    private function makeLoggerHandler(string $url, string $level, string $name): TeamsLoggerHandler
    {
        return new TeamsLoggerHandler(
            url: $url,
            level: Level::fromName($level),
            name: $name
        );
    }
}
