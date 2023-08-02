<?php

namespace App\View\Components\Navbar;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class SideItem extends Component
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
        return view('components.navbar.side-item');
    }

    /**
     * Menu items
     *
     * @return array
     */
    public function items(): array
    {
        return [
            "" => [
                "sub-item" => [
                    [
                        "icon" => "building icon",
                        "icon-type" => "icon",
                        "type" => "item",
                        "name" => "Clients",
                        "route" => "client",
                        "current" => $this->current("client"),
                    ],
                    [
                        "name" => "Articles",
                        "icon" => "cubes icon",
                        "icon-type" => "icon",
                        "type" => "item",
                        "can" => true,
                        "route" => "article",
                        "current" => $this->current("article"),
                    ],
                ],
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
