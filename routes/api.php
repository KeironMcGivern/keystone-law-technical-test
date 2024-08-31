<?php

use App\Http\Controllers\Api\LinkSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/get-links', LinkSearchController::class)->name('api.getLinks');
