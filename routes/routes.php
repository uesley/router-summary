<?php

use Illuminate\Support\Facades\Route;
use Uesley\RouterSummary\Controllers\ListEndpointController;

Route::get('api/endpoints', ListEndpointController::class);