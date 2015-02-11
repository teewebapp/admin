<?php

namespace Tee\Admin\Controllers;

use Tee\System\Controllers\BaseController;
use View, URL, Config;

use Tee\System\Breadcrumbs;

class AdminBaseController extends BaseController {

    public function __construct() {
        Config::set('site.theme', null);
        $this->makeMenu();
        View::share('pageTitle', '');

        Breadcrumbs::removeAll();
        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb('Visão Geral', URL::to('admin'));
    }

    public function makeMenu() {
        return app()->make('admin::dashboardMenu');
    }

}