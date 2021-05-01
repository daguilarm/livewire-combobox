<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Daguilarm\LivewireCombobox\LivewireComboboxServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Laravel\Dusk\Browser;
use Livewire\LivewireServiceProvider;
use Livewire\Macros\DuskBrowserMacros;
use Orchestra\Testbench\Dusk\TestCase;

class BrowserTestCase extends TestCase
{
    public function setUp(): void
    {
        // DuskOptions::withoutUI();
        if (isset($_SERVER['CI'])) {
            DuskOptions::withoutUI();
        }

        Browser::mixin(new DuskBrowserMacros);

        // Clean up the test
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        $this->tweakApplication(function () {
            //Routes for testing
            Route::get('/testing', function() {
                return view('select');
            });
        });
    }

    /**
     * Load the Service Providers
    */
    protected function getPackageProviders($app)
    {
        return [
            LivewireComboboxServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    /**
     * Setup environment
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup the application
        $app['config']->set('view.paths', [
            __DIR__.'/../tests/Browser/resources/views',
            resource_path('views'),
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('session.driver', 'file');
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Clean up for the test.
     */
    public function makeACleanSlate()
    {
        Artisan::call('view:clear');

        File::deleteDirectory($this->livewireViewsPath());
        File::deleteDirectory($this->livewireClassesPath());
        File::deleteDirectory($this->livewireTestsPath());
        File::delete(app()->bootstrapPath('cache/livewire-components.php'));
    }

    /**
     * Get all the dusk attributes.
     */
    public function getDuskAttributes($html)
    {
        preg_match_all('/dusk="(.*)"/', $html, $results);

        return $results[1];
    }

    /**
     * Swap HTTP Kernel for application bootstrap.
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Daguilarm\LivewireCombobox\Tests\HttpKernel');
    }

    /**
     * Set the path for the livewire classes.
     */
    protected function livewireClassesPath($path = '')
    {
        return app_path('Http/Livewire'.($path ? '/'.$path : ''));
    }

    /**
     * Set the path for the livewire views.
     */
    protected function livewireViewsPath($path = '')
    {
        return resource_path('views').'/livewire'.($path ? '/'.$path : '');
    }

    /**
     * Set the path for the livewire tests.
     */
    protected function livewireTestsPath($path = '')
    {
        return base_path('tests/Feature/Livewire'.($path ? '/'.$path : ''));
    }
}
