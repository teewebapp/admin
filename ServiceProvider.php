<?php

namespace Tee\Admin;
use Tee\System\Menu;
use Event;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function register()
    {
        $app = $this->app;
        // registramos o menu do container
        $this->app->singleton('admin::dashboardMenu', function() use($app) {
            return Menu::make('dashboardMenu', function($menu) use($app) {
                $format = '<img src="%s" class="fa" />&nbsp;&nbsp;<span>%s</span>';
                $menu->add(sprintf($format, moduleAsset('admin', '/images/icon_home.png'), 'Visão Geral'), 'admin');
                Event::fire('admin::menu.load', array($menu));
            });
        });
    }
}
