<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class CountWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    //protected $config = [];
    protected $config = [
        'color' => 'bg-light-green',
        'bg_color' => 'bg-pink',
        'icon' => 'playlist_add_check',
        'title' => 'New',
        'coll_class' => 'col-lg-3 col-md-3 col-sm-6 col-xs-12',
        'counter' => 0
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        /*return view('widgets.count_widget', [
            'config' => $this->config,
        ]);*/
        return view('widgets.count_widget', [
            'config' => $this->config,
            'counter' => 334
        ]);
    }
}
