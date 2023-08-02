<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

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
            ->select(DB::raw("article_id AS id, article_id"))
            ->with(['article'])
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->where('article_id', $cond['article_id']);
            })
            ->when(key_exists('zone_id', $cond), function ($q) use ($cond) {
                $q->where('zone_id', $cond['zone_id']);
            })
            ->when(key_exists('prospect_id', $cond), function ($q) use ($cond) {
                $q->whereHas('article', function ($qha) use ($cond) {
                    $qha->where('cc_articles.prospect_id', $cond['prospect_id']);
                });
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->whereHas('article', function ($qha) {
                    $qha->where('cc_articles.prospect_id', Auth::user()->clients()->first()->id);
                });
            })
            ->groupBy('article_id');
    }

    /**
     * Column's grid
     *
     * @param mixed $cond
     * @return array
     */
    public static function gridColumns($cond = []): array
    {
        $_columns = [
            // [
            //     "name" => "Id",
            //     "data" => "id",
            //     'column' => "id",
            //     "render" => false,
            //     "className" => 'left aligned',
            //     "width" => "75px",
            // ],
            // [
            //     "name" => "Référence",
            //     "data" => "ref",
            //     'column' => 'ref',
            //     "render" => false,
            //     "edit" => 'data-field="red" data-model="/article/savewhat" data-type="text"',
            //     "className" => 'left aligned open_child open editFieldLine',
            // ],
            // [
            //     "name" => "Désignation",
            //     "data" => "designation",
            //     'column' => 'designation',
            //     "render" => false,
            //     "edit" => 'data-field="designation" data-model="/article/savewhat" data-type="text"',
            //     "className" => 'left aligned open_child open editFieldLine',
            // ],
            // [
            //     "name" => "PU",
            //     "data" => "puht",
            //     'column' => 'puht',
            //     "render" => false,
            //     "edit" => 'data-field="puht" data-model="/article/savewhat" data-type="decimal"',
            //     "className" => 'right aligned  editFieldLine',
            // ],
            [
                "name" => "Référence",
                "data" => "article.ref",
                'column' => 'article_id',
                "render" => 'relation',
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Désigantion",
                "data" => "article.designation",
                'column' => 'article_id',
                "render" => 'relation',
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Client",
                "data" => "article.client_name",
                'column' => 'article_id',
                "render" => 'relation',
                'visible' => key_exists('wclient', $cond),
                "className" => 'left aligned open_child',
            ],
            // [
            //     "name" => "",
            //     "data" => "default",
            //     'column' => "/handle/render?com=default&model=article&D=D&width=50",
            //     "render" => 'url',
            //     "className" => 'center aligned open p-0',
            //     "visible" => Gate::allows('create', [self::class]),
            //     'width' => "55px"
            // ],
            // [
            //     "name" => "Code",
            //     "data" => "code_article",
            //     'column' => 'code_article',
            //     "render" => false,
            //     "className" => 'left aligned open_child open item',
            // ],
            // [
            //     "name" => "Famille",
            //     "data" => "famille.nom",
            //     'column' => 'famille.nom',
            //     "render" => 'relation',
            //     "className" => 'left aligned open_child open item',
            // ],
            // [
            //     "name" => "Tailles",
            //     "data" => "tailles",
            //     'column' => 'tailles',
            //     "render" => false,
            //     "className" => 'left aligned open_child open item',
            // ],
            // [
            //     "name" => "Points",
            //     "data" => "points",
            //     'column' => 'points',
            //     "render" => false,
            //     "className" => 'right aligned open_child open item',
            // ],
            // [
            //     "name" => "Prix",
            //     "data" => "prix",
            //     'column' => 'prix',
            //     "render" => false,
            //     "className" => 'right aligned open_child open item',
            // ],
            // [
            //     "name" => "Dans le métier",
            //     "data" => "metier_checkbox",
            //     'column' => "/handle/render?com=_metier_checkbox_column&model=article&metier=" . (key_exists('vmetier', $cond) ? $cond['vmetier'] : ''),
            //     "render" => 'url',
            //     "className" => 'center aligned open p-0',
            //     "visible" => key_exists('vmetier', $cond),
            // ],
        ];

        foreach (Zone::orderBy('order')->get() as $zone) {
            array_push($_columns, [
                "name" => $zone->libelle,
                "data" => "zone_qty_$zone->id",
                'column' => "/handle/render?com=stock-zone&model=article&zone_id=$zone->id",
                "render" => 'url',
                "width" => "120px",
                "className" => 'center aligned',
            ]);
        }

        array_push($_columns, [
            "name" => "Total",
            "data" => "total_zone_qty_$zone->id",
            'column' => "/handle/render?com=total-stock-zone&model=article",
            "render" => 'url',
            "width" => "75px",
            "className" => 'right aligned',
        ]);

        return $_columns;
    }

    /**
     * get related articles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * get related zones
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Summary of article
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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
        "article_id",
        "zone_id",
        "qte",
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
