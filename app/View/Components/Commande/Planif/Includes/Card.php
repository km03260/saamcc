<?php

namespace App\View\Components\Commande\Planif\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public String $week, public string $statut, public string $sem, public $commande)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.commande.planif.includes.card');
    }
}
