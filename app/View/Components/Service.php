<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Service extends Component
{

    public $name;
    public $url;
    public $image;
    public $type;
    public $comming;
    public $info;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $url, $image, $type=null,$info=null, $comming=false)
    {
        $this->name = $name;
        $this->url = $url;
        $this->image = $image;
        $this->type = $type;
        $this->comming = $comming;
        $this->info = $info;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service');
    }
}
