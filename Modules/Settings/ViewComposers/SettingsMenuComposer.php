<?php

namespace Modules\Settings\ViewComposers;

use Illuminate\Support\Facades\Lang;
use Illuminate\View\View;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

/**
 * Class SettingsMenuComposer
 * @package Modules\Platform\Settings\ViewComposers
 */
class SettingsMenuComposer
{


    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $settingsMenu = Menu::new();
        $settingsMenu->addClass('list-group list-menu card');
        $settingsMenu->setActiveFromUrl(url()->current());

        // General Settings
        /*$settingsMenu->add(Html::raw('<h5>'.Lang::get('core.settings.menu.account.label').'</h5>')->addParentClass('header'));*/
        $settingsMenu->add(Link::to(route('settings.index'), Lang::get('core.settings.menu.account.label')));
        $settingsMenu->add(Link::to(route('password_settings.index'), Lang::get('core.settings.menu.security.label')));
        $settingsMenu->add(Link::to(route('company_settings.index'), Lang::get('core.settings.menu.company.label')));
        //$settingsMenu->add(Link::to(route('settings.user_settings'), trans('core.settings.menu.users')));
        


        $settingsMenu->each(function (Link $link) {
            $link->addClass('list-group-item');
        });



        $view->with('settingsMenu', $settingsMenu);
    }
}
