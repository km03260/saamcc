<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Stock extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "cc_stocks";

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
            ->leftJoin('cc_mouvements as m', "$this->table.id", "m.stock_id")
            ->select(DB::raw("article_id AS id, article_id, SUM(m.perte) AS total_perte"))
            ->with(['article'])
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->where('article_id', $cond['article_id']);
            })
            ->when(key_exists('zone_id', $cond), function ($q) use ($cond) {
                $q->where("$this->table.zone_id", $cond['zone_id']);
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
                'visible' => key_exists('wclient', $cond) && !Gate::allows('is_client', User::class),
                "className" => 'left aligned open_child',
            ],
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
            "name" => "total des pertes",
            "data" => "total_perte",
            'column' => "total_perte",
            "render" => false,
            'visible' =>  !Gate::allows('is_client', User::class),
            "className" => 'right aligned open_child',
        ]);
        array_push($_columns, [
            "name" => "Total",
            "data" => "total_zone_qty_$zone->id",
            'column' => "/handle/render?com=total-stock-zone&model=article",
            "render" => 'url',
            "width" => "75px",
            "className" => 'right aligned open_child',
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
     * get related mouvement
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mouvements()
    {
        return $this->hasMany(Mouvement::class);
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

    const LAST_ZONE = 4;

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
