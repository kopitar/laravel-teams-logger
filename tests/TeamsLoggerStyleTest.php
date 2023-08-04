<?php

namespace Kopitar\LaravelTeamsLogger\Tests\Unit;

use Kopitar\LaravelTeamsLogger\Style\Color;
use Kopitar\LaravelTeamsLogger\Style\Avatar;
use Orchestra\Testbench\TestCase as Orchestra;

class TeamsLoggerStyleTest extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_that_color_enum_from_level_returns_a_string(): void
    {
        $this->assertIsstring(
            (Color::fromLevel('DEBUG'))->value
        );
    }

    public function test_that_color_enum_returns_config_value_if_set(): void
    {
        config(['teams_logger.colors.debug' => '#ff0000']);
        $this->assertEquals('#ff0000', Color::get('DEBUG'));
    }

    public function test_that_avatar_enum_from_level_returns_a_string(): void
    {
        $this->assertIsstring(
            (Avatar::fromLevel('DEBUG'))->value
        );
    }

    public function test_that_avatar_enum_returns_config_value_if_set(): void
    {
        config(['teams_logger.avatars.debug' => 'http://avatar-url.com/image.jpg']);
        $this->assertEquals('http://avatar-url.com/image.jpg', Avatar::get('DEBUG'));
    }
}
