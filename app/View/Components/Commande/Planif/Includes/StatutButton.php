<?php

namespace App\View\Components\Commande\Planif\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class StatutButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Model $commande)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.commande.planif.includes.statut-button');
    }
}
