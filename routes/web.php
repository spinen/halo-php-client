<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Spinen\Halo\Http\Controllers\HaloController;

Route::get(rtrim(Config::get('halo.oauth.authorization_code.route.sso', '/halo/sso'), '/'), HaloController::class)
     ->name('halo.sso.redirect_uri');
