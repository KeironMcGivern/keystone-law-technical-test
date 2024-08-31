<?php

use App\Http\Controllers\PinnedLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PinnedLinkController::class, 'index'])->name('pinnedLinks');
