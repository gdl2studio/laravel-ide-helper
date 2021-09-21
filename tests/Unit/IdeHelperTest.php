<?php

namespace Gdl2Studio\IdeHelper\Tests\Unit;

use Gdl2Studio\IdeHelper\Facades\IdeHelper as IdeHelperFacade;
use Gdl2Studio\IdeHelper\IdeHelper;
use Gdl2Studio\IdeHelper\Tests\TestCase;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use TestApp\DummyAFacade;
use TestApp\Facades\DummyBFacade;

class IdeHelperTest extends TestCase
{
    use InteractsWithConsole;

    /**
     * @test
     */
    public function loads_only_in_local_environment()
    {
        $ideHelper = app()->get('gdl2studio.ide-helper');
        $this->assertIsObject($ideHelper);
        $this->assertEquals(IdeHelper::class, get_class($ideHelper));

        $this->environment = 'prod';
        $this->reloadApplication();
        $this->expectExceptionObject(new EntryNotFoundException('gdl2studio.ide-helper'));
        app()->get('gdl2studio.ide-helper');
    }

    /**
     * @test
     */
    public function it_parses_facades_in_apps_dir()
    {
        $facades = IdeHelperFacade::withNoWrite()
            ->parseAppFacades()
            ->getParsedFacades();

        $this->assertArrayHasKey(DummyAFacade::class, $facades);
        $this->assertArrayHasKey(DummyBFacade::class, $facades);
        $this->assertStringContainsString('* @method static void publicFnA()', $facades[DummyAFacade::class]);
        $this->assertStringContainsString('* @method static functionB()', $facades[DummyBFacade::class]);

        // dump($facades);
    }

    /**
     * @test
     */
    public function it_registers_command_to_parse_app_facades()
    {
        $this->artisan('ide-helper:facades')
            ->expectsOutput('Annotations generated for:')
            ->expectsOutput(DummyAFacade::class.': ')
            ->expectsOutput(DummyBFacade::class.': ')
            ->run();

        $this->artisan('ide-helper:facades -w')
            ->expectsOutput('Annotations generated for:')
            ->expectsOutput(' '.DummyAFacade::class)
            ->expectsOutput(' '.DummyBFacade::class)
            ->run();

        IdeHelperFacade::withWrite()
            ->cleanUpAppFacades();
    }
}
