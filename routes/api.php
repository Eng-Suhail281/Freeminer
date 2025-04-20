<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/register_user', [UserController::class, 'registerFromTelegram']);
