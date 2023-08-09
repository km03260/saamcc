<?php

namespace App\View\Components\Commande\Ligne;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Row extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Model $client)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.commande.ligne.row')->with([
            'vdata' => Str::random(64),
        ]);
    }
}
