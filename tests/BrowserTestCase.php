<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Closure;
use Daguilarm\LivewireCombobox\LivewireComboboxServiceProvider;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Livewire\LivewireServiceProvider;
use Livewire\Macros\DuskBrowserMacros;
use Orchestra\Testbench\Dusk\Foundation\Console\DuskCommand;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\Dusk\TestCase;
use Psy\Shell;

class BrowserTestCase extends TestCase
{
    use SupportsSafari;

    public static $useSafari = false;

    public function setUp(): void
    {
        // DuskOptions::withoutUI();
        if (isset($_SERVER['CI'])) {
            DuskOptions::withoutUI();
        }

        // Clean up the test
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        // Define the testing routes
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
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
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

    protected function driver(): RemoteWebDriver
    {
        $options = DuskOptions::getChromeOptions();

        $options->setExperimentalOption('prefs', [
            'download.default_directory' => __DIR__.'/downloads',
        ]);

        return static::$useSafari
            ? RemoteWebDriver::create(
                'http://localhost:9515', DesiredCapabilities::safari()
            )
            : RemoteWebDriver::create(
                'http://localhost:9515',
                DesiredCapabilities::chrome()->setCapability(
                    ChromeOptions::CAPABILITY,
                    $options
                )
            );
    }

    public function browse(Closure $callback)
    {
        parent::browse(function (...$browsers) use ($callback) {
            try {
                $callback(...$browsers);
            } catch (Exception $e) {
                if (DuskOptions::hasUI()) $this->breakIntoATinkerShell($browsers, $e);

                throw $e;
            } catch (Throwable $e) {
                if (DuskOptions::hasUI()) $this->breakIntoATinkerShell($browsers, $e);

                throw $e;
            }
        });
    }

    public function breakIntoATinkerShell($browsers, $e)
    {
        $sh = new Shell();

        $sh->add(new DuskCommand($this, $e));

        $sh->setScopeVariables([
            'browsers' => $browsers,
        ]);

        $sh->addInput('dusk');

        $sh->setBoundObject($this);

        $sh->run();

        return $sh->getScopeVariables(false);
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
