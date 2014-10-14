<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\System\Controllers\BaseController;
use View, Theme, URL, Breadcrumbs, Menu;

class AdminBaseController extends BaseController {

    public function __construct() {
        $this->makeMenu();
        Theme::init('admin');
        View::share('pageTitle', '');
        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb('Visão Geral', URL::to('admin'));
    }

    public function makeMenu() {
        Menu::make('dashboardMenu', function($menu) {
            $app = app();
            $format = '<img src="%s" class="fa" />&nbsp;&nbsp;<span>%s</span>';
            $menu->add(sprintf($format, moduleAsset('admin', '/images/icon_home.png'), 'Visão Geral'), 'admin');
            foreach($app['modules']->modules() as $name => $module) {
                if(!$module->enabled())
                    continue;
                $options = null;
                if($module->def('admin'))
                {
                    $admin = $module->def('admin');
                    $options = $admin['menuOptions'];
                }

                if($options)
                {
                    foreach($options as $option)
                    {
                        $menu->add(sprintf($format, URL::to($option['icon']), $option['label']), URL::to($option['url']));
                    }
                }
            }
        });
    }

}