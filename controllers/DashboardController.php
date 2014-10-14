<?php

namespace Tee\Admin\Controllers;

use View, URL, Menu;

class DashboardController extends AdminBaseController {

    public function index() {
        View::share('pageTitle', 'Visão Geral');
        return View::make('admin::dashboard.index');
    }

}