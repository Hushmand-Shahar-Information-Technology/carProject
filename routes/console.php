<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('auctions:end-expired')
    ->everyMinute()
    ->name('end-expired-auctions')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('test:scheduler')
    ->everyFiveMinutes()
    ->name('test-scheduler')
    ->withoutOverlapping()
    ->runInBackground();