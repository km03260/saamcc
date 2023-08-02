<?php

namespace App\View\Components\Includes;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Dropdown extends Component
{

    /**
     * Dropdown version key
     *
     * @var string
     */
    public $vdrop;

    /**
     * Classes of dropdown
     *
     * @var string
     */
    public $classes;

    /**
     * name of dropdown
     *
     * @var string
     */
    public $name;

    /**
     * value of dropdown
     *
     * @var string
     */
    public $value;

    /**
     * placeholder of dropdown
     *
     * @var string
     */
    public $placeholder;

    /**
     * url of dropdown
     *
     * @var string
     */
    public $url;

    /**
     * Allow multiple select
     *
     * @var string
     */
    public $multiple;

    /**
     * Append more info
     *
     * @var string
     */
    public $appends;

    /**
     * Allow push select
     *
     * @var bool
     */
    public $push;

    /**
     * Gives the ability to add their own options
     *
     * @var bool
     */
    public $allowAdditions;

    /**
     * Styles of dropdown
     *
     * @var string
     */
    public $styles;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes, $name, $value, $placeholder, $url, $multiple = 0, $push = true, $appends = '', $allowAdditions = false, $styles = "")
    {
        $this->vdrop = Str::random(46);
        $this->classes = $classes;
        $this->styles = $styles;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->url = $url;
        $this->multiple = $multiple == 1 ? true : false;
        $this->push = $push;
        $this->appends = $appends;
        $this->allowAdditions = $allowAdditions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.includes.dropdown');
    }
}
