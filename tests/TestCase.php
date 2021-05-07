<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Daguilarm\LivewireCombobox\LivewireComboboxServiceProvider;
use Daguilarm\LivewireCombobox\Tests\App\Http\Livewire\ComboboxOptions;
use Daguilarm\LivewireCombobox\Tests\App\Http\Livewire\ComboboxSelects;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\Dusk\TestCase as BaseTestCase;

/**
 * @see https://github.com/livewire/livewire/blob/master/tests/Browser/TestCase.php
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

            // Components for testing
            Livewire::component('combobox-selects', ComboboxSelects::class);
            Livewire::component('combobox-options', ComboboxOptions::class);

            //Routes for testing
            Route::get('/testing', function () {
                return view('select');
            });
            Route::get('/testing/options', function () {
                return view('options');
            });
        });
    }

    /**
     * Setup environment.
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup the application
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
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
     * Resolve the application http kernel.
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', '\Daguilarm\LivewireCombobox\Tests\HttpKernel');
    }
}
