<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{

    /**
     * Tabs
     *
     * @var array
     */
    public array $tabs;

    /**
     * Called after a tab becomes visible
     * @var string
     */
    public $onVisible;

    /**
     * Create a new component instance.
     */
    public function __construct(public String $name, public String $url,  $tabs, string $onVisible = '', public string $styles = '')
    {
        $this->tabs = $tabs;
        $this->onVisible = htmlspecialchars(json_encode($onVisible), ENT_QUOTES, 'utf-8');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab');
    }
}
