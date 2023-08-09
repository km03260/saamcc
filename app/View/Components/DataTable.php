<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class DataTable extends Component
{
    /**
     * List name of datatable
     *
     * @var string
     */
    public $list;

    /**
     * Version data
     *
     * @var string
     */
    public $vdata;

    /**
     * Display info
     *
     * @var bool
     */
    public $bInfo;

    /**
     * Display pagination
     *
     * @var bool
     */
    public $paging;

    /**
     * Display ordering
     *
     * @var bool
     */
    public $ordering;

    /**
     * Length of page
     *
     * @var int
     */
    public $length;

    /**
     * Order column
     *
     * @var
     */
    public $order;

    /**
     * Order direction
     *
     * @var
     */
    public $dir;

    /**
     * Determine if parent datatable
     *
     * @var
     */
    public $parent;

    /**
     * Fix header
     *
     * @var bool
     */
    public $fixedHeader;

    /**
     * table footer
     *
     * @var bool|string
     */
    public $ctfoot;

    /**
     * table footer
     *
     * @var array
     */
    public $tfoot;

    /**
     * show childrow
     *
     * @var bool
     */
    public $childRow;

    /**
     * show childrow
     *
     * @var bool
     */
    public $noHead;

    /**
     * Disabled server side
     *
     * @var bool
     */
    public $dServerSide;

    /**
     * show search field
     *
     * @var bool
     */
    public $searching;

    /**
     * Cudtomize length
     *
     * @var bool
     */
    public $customLength;

    /**
     * Cudtomize classes
     *
     * @var string
     */
    public $classes;

    /**
     * Cudtomize appends
     *
     * @var string
     */
    public $appends;

    /**
     * Open row default
     *
     * @var string
     */
    public $open;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $list,
        $bInfo = true,
        $paging = true,
        $length = 20,
        $order = 0,
        $ordering = true,
        $vdata = null,
        $dir = "asc",
        $parent = true,
        $fixedHeader = false,
        $dServerSide = true,
        $searching = false,
        $tfoot = false,
        $childRow = false,
        $noHead = false,
        $customLength = false,
        $classes = "",
        $appends = "",
        $open = false
    ) {
        $this->list = $list;
        $this->bInfo = $bInfo;
        $this->paging = $paging;
        $this->length = $length;
        $this->order = $order;
        $this->ordering = $ordering;
        $this->dir = $dir;
        $this->parent = $parent;
        $this->noHead = $noHead;
        $this->fixedHeader = $fixedHeader;
        $this->ctfoot = $tfoot;
        $this->tfoot = $this->footerColumns($tfoot);
        $this->vdata = $vdata ?? Str::random(46);
        $this->childRow = $childRow;
        $this->customLength = $customLength;
        $this->classes = $classes;
        $this->appends = $appends;
        $this->searching = $searching;
        $this->dServerSide = $dServerSide;
        $this->open = $open;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table', [
            "params" => $this->api()[$this->list],
        ]);
    }

    /**
     * Data api
     *
     * @return \Illuminate\Support\Collection
     */
    private function api()
    {
        return collect([
            "clients" => [
                "url" => Route('client.grid'),
                "vdata" => $this->vdata,
                "name" => "clients",
                "list" => "list_clients$this->vdata",
                "key" => "id",
            ],
            "articles" => [
                "url" => Route('article.grid'),
                "vdata" => $this->vdata,
                "name" => "articles",
                "list" => "list_articles$this->vdata",
                "key" => "id",
            ],
            "stocks" => [
                "url" => Route('stock.grid'),
                "vdata" => $this->vdata,
                "name" => "stocks",
                "list" => "list_stocks$this->vdata",
                "key" => "id",
            ],
            "mouvements" => [
                "url" => Route('mouvement.grid'),
                "vdata" => $this->vdata,
                "name" => "mouvements",
                "list" => "list_mouvements$this->vdata",
                "key" => "id",
            ],
            "commandes" => [
                "url" => Route('commande.grid'),
                "vdata" => $this->vdata,
                "name" => "commandes",
                "list" => "list_commandes$this->vdata",
                "key" => "id",
            ],
            "lcommandes" => [
                "url" => Route('commande.ligne.grid'),
                "vdata" => $this->vdata,
                "name" => "commandes",
                "list" => "list_lcommandes$this->vdata",
                "key" => "id",
            ],
            "users" => [
                "url" => Route('user.grid'),
                "vdata" => $this->vdata,
                "name" => "users",
                "list" => "list_users$this->vdata",
                "key" => "id",
            ],
            "variations" => [
                "url" => Route('variation.grid'),
                "vdata" => $this->vdata,
                "name" => "variations",
                "list" => "list_variations$this->vdata",
                "key" => "id",
            ],
        ]);
    }

    /**
     * Determine columns footer
     * 
     * @param mixed $tfoot
     * @return array<array>
     */
    private function footerColumns($tfoot)
    {
        $_tfoot = [];
        if ($tfoot) {
            foreach (explode(',', $tfoot) as $cvl) {
                $column_ft = explode('_c', $cvl);
                $_tfoot[] = [
                    "index" => $column_ft[1],
                    "name" => $column_ft[0],
                ];
            }
        }
        return $_tfoot;
    }
}
