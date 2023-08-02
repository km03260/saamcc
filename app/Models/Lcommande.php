<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Lcommande extends Model
{
    use HasFactory;


    /**
     * Table name
     * @var string
     */
    protected $table = "cc_commande_articles";

    /**
     * Scope grid
     * 
     * @param Builder $query
     * @param array $cond
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);
        return $query
            ->select(DB::raw("$this->table.*, $this->table.pu * $this->table.qty AS total"))
            ->with(['article'])
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->where('article_id', $cond['article_id']);
            })
            ->when(key_exists('commande_id', $cond), function ($q) use ($cond) {
                $q->where('commande_id', $cond['commande_id']);
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            });
    }


    /**
     * Column's grid
     *
     * @param mixed $cond
     * @return array
     */
    public static function gridColumns($cond = []): array
    {
        return [
            [
                "name" => "Id",
                "data" => "id",
                'column' => "id",
                "render" => false,
                "className" => 'left aligned',
                "width" => "75px",
            ],
            [
                "name" => "Référence",
                "data" => "article.ref",
                'column' => 'article_id',
                "render" => 'relation',
                "className" => 'left aligned',
            ],
            [
                "name" => "Désignation",
                "data" => "article.designation",
                'column' => 'article_id',
                "render" => 'relation',
                "className" => 'left aligned',
            ],
            [
                "name" => "Prix unitaire",
                "data" => "pu",
                'column' => 'pu',
                "render" => false,
                "className" => 'right aligned',
            ],
            [
                "name" => "Quantité",
                "data" => "qty",
                'column' => 'qty',
                "render" => false,
                "className" => 'right aligned',
            ],
            [
                "name" => "Total",
                "data" => "total",
                'column' => 'total',
                "render" => false,
                "className" => 'right aligned',
            ],
            [
                "name" => "",
                "data" => "default",
                'column' => "/handle/render?com=default&model=lcommande&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [Commande::class]),
                'width' => "55px"
            ],
        ];
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'commande_id',
        'article_id',
        'qty',
        'pu',
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($_mdl) {
            $_mdl->created_by = Auth::id();
        });
        static::updating(function ($_mdl) {
            $_mdl->updated_by = Auth::id();
        });
    }
}
