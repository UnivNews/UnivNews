<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Boost;

Schedule::call(function () {
    Boost::where('status', 'scheduled')
        ->where('start_date', '<=', now()->toDateString())
        ->update(['status' => 'active']);
})->hourly();

Schedule::call(function () {
    Boost::where('status', 'active')
        ->where('end_date', '<', now()->toDateString())
        ->update(['status' => 'expired']);
})->hourly();
