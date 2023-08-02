<?php

namespace App\View\Components\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListeTitle extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $title, public String $subtitle, public String $icon)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.includes.liste-title');
    }
}
