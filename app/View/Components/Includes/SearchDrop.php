<?php

namespace App\View\Components\Includes;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class SearchDrop extends Component
{
    /**
     * data version key
     *
     * @var string
     */
    public $vdata;

    /**
     * Search version key
     *
     * @var string
     */
    public $vsearch;

    /**
     * Classes of search
     *
     * @var string
     */
    public $classes;

    /**
     * name of search
     *
     * @var string
     */
    public $name;

    /**
     * value of search
     *
     * @var string
     */
    public $value;

    /**
     * text of search
     *
     * @var string
     */
    public $text;

    /**
     * placeholder of search
     *
     * @var string
     */
    public $placeholder;

    /**
     * url of search
     *
     * @var string
     */
    public $url;

    /**
     * Minimum characters to query for results
     *
     * @var string
     */
    public $minCharacters;

    /**
     * Whether search should show results on focus (must also match min character length)
     *
     * @var string
     */
    public $searchOnFocus;

    /**
     * Appends data
     *
     * @var string
     */
    public $appends;

    /**
     * Refer field
     *
     * @var string
     */
    public $refer;

    /**
     * Push script
     *
     * @var bool
     */
    public $push;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($vdata, $classes, $name, $value, $placeholder, $url, $text = '', $minCharacters = 3, $searchOnFocus = 0, $appends = "", $refer = null, $push = false)
    {
        $this->vdata = $vdata;
        $this->vsearch = Str::random(46);
        $this->classes = $classes;
        $this->name = $name;
        $this->value = $value;
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->url = $url;
        $this->minCharacters = $minCharacters;
        $this->searchOnFocus = $searchOnFocus;
        $this->push = $push;
        $this->appends = $appends;
        $this->refer = $refer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.includes.search-drop');
    }
}
