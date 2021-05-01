<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Daguilarm\LivewireCombobox\LivewireComboboxServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Dusk\TestCase as BaseTestCase;

/**
 * @see https://github.com/livewire/livewire/blob/master/tests/Browser/SupportsSafari.php
 * @see https://github.com/appstract/laravel-dusk-safari
 */
class TestCase extends BaseTestCase
{
    use DuskElements;

    /**
     * Setup for testing.
     */
    public function setUp(): void
    {
        // DuskOptions::withoutUI();
        if (isset($_SERVER['CI'])) {
            DuskOptions::withoutUI();
        }

        parent::setUp();

        // Define the testing routes
        $this->tweakApplication(function () {
            // Enable debug
            config()->set('app.debug', true);
            // Configure the view folder
            app('config')->set('view.paths', [
                __DIR__.'/../tests/Browser/resources/views',
                resource_path('views'),
            ]);
            // CSRF hack
            app('session')->put('_token', 'this-is-a-hack-because-something-about-validating-the-csrf-token-is-broken');
            //Routes for testing
            Route::get('/testing', function () {
                return view('select');
            });
        });
    }

    /**
     * Load the Service Providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            LivewireComboboxServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    /**
     * Setup environment.
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup the application
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('filesystems.disks.dusk-downloads', [
            'driver' => 'local',
            'root' => __DIR__.'/downloads',
        ]);
    }

    /**
     * Resolve the application http kernel.
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', '\Daguilarm\LivewireCombobox\Tests\HttpKernel');
    }
}
