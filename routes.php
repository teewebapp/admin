<?php

namespace Tee\Admin;
use Route;

Route::when('admin/*', 'auth');

Route::get('/admin', __NAMESPACE__.'\Controllers\DashboardController@index');