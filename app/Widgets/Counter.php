<?php

namespace App\Widgets;
use Arrilot\Widgets\AbstractWidget;

class Counter extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'count' => 0,
        'title' => '',
        'bg' => '',
        'icon' => ''
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.counter', [
            'config' => $this->config,
        ]);
    }
}
