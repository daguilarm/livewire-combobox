<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Daguilarm\LivewireCombobox\LivewireComboboxServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // Clean up the test
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();
    }

    /**
     * Load the service providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            LivewireComboboxServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    /**
     * Setup the testing environment.
     */
    public function getEnvironmentSetUp($app)
    {
        // Setup the application
        $app['config']->set('view.paths', [
            __DIR__.'/../tests/_Resources/_Views/',
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
