<?php

use Illuminate\Foundation\Configuration\Console;

return Console::configure()
    ->withSchedule(function (Illuminate\Console\Scheduling\Schedule $schedule) {
        // $schedule->command('inspire')->hourly();
    })
    ->withCommands([
        // Register your commands here
    ])
    ->create();
