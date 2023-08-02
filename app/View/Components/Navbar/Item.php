<?php

namespace App\View\Components\Navbar;

use Illuminate\View\Component;

class Item extends Component
{

    /**
     * Item details
     *
     * @var array
     */
    public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar.item');
    }
}
