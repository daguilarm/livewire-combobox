<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

/**
 * @see https://github.com/livewire/livewire/blob/master/tests/Browser/SupportsSafari.php
 * @see https://github.com/appstract/laravel-dusk-safari
 */
trait SupportsSafari
{
    protected static $safariProcess;

    /**
     * Before the class
     */
    public static function prepare()
    {
        if (static::$useSafari) {
            static::startSafariDriver();
        } else {
            static::startChromeDriver(['port' => 9515]);
        }
    }

    /**
     * Only on chrome.
     */
    public function onlyRunOnChrome()
    {
        static::$useSafari && $this->markTestSkipped();
    }

    /**
     * Safari driver.
     */
    public static function startSafariDriver()
    {
        static::$safariProcess = new \Symfony\Component\Process\Process([
            '/usr/bin/safaridriver', '-p 9515',
        ]);

        static::$safariProcess->start();

        static::afterClass(function () {
            if (static::$safariProcess) {
                static::$safariProcess->stop();
            }
        });
    }
}
