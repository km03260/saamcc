<?php

namespace App\View\Components\Navbar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar.menu', [
            "items" => $this->items(),
        ]);
    }

    /**
     * Menu items
     *
     * @return array
     */
    public function items(): array
    {
        return [
            "Clients" => [
                "name" => Auth::user()->Profil == 8 ? "" : "Clients",
                "icon" => "building icon",
                "icon-type" => "icon",
                "type" => Auth::user()->Profil == 8 ?  "inline" : 'item',
                "can" => Gate::allows('access', [\App\Models\Client::class]),
                "route" => "/",
                "current" => $this->current("clients"),
            ],
            "Articles" => [
                "name" => "Articles",
                "icon" => "building icon",
                "icon-type" => "icon",
                "type" => "item",
                "can" => true,
                "route" => "/article/index",
                "current" => $this->current("articles"),
            ],
            "Stocks" => [
                "name" => "Stock",
                "icon" => "building icon",
                "icon-type" => "icon",
                "type" => "item",
                "can" => true,
                "route" => "/stock/index",
                "current" => $this->current("stocks"),
            ],
            "Commandes" => [
                "name" => "Commandes",
                "icon" => "shopping cart icon",
                "icon-type" => "icon",
                "type" => "item",
                "can" => true,
                "route" => "/commande/index",
                "current" => $this->current("commandes"),
            ],
            "Utilisateurs" => [
                "name" => "Utilisateurs",
                "icon" => "users icon",
                "icon-type" => "icon",
                "type" => "item",
                "can" => true,
                "route" => "/user/index",
                "current" => $this->current("users"),
            ],
        ];
    }

    /**
     * Check of is current name
     *
     * @param string $routeName
     * @return string
     */
    private function current(string $routeName): string
    {
        return Request::route()->getName() == $routeName
            ? 'active'
            : '';
    }
}
