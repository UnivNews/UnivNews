<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = \Illuminate\Http\Request::create("/webhooks/mayar", "POST", [
    "event" => "paid",
    "data" => ["id" => "04fbdf85-535b-4e11-b9b7-ae0fc640ab28"]
]);

echo app(\App\Http\Controllers\WebhookController::class)
    ->handleMayar($req, app(\App\Services\MayarService::class))
    ->getContent();
