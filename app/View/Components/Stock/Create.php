<?php

namespace App\View\Components\Stock;

use App\Models\Zone;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Create extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $zones = Zone::orderBy('order')->get();
        return view('components.stock.create')->with(['zones' => $zones]);
    }
}
