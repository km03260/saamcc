<?php

namespace App\Models;

use App\Helpers\Loader;
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
            ->select(DB::raw("$this->table.*,
             CONCAT((CASE WHEN a.designation IS NOT NULL THEN a.designation ELSE ''END) ,' ', (CASE WHEN  $this->table.variation IS NOT NULL THEN REPLACE( $this->table.variation, '/', ' ') ELSE ''END)) AS designation, 
              $this->table.pu * $this->table.qty AS total, sc.background AS line_color"))
            ->with(['article', 'statut'])
            ->leftJoin('cc_commande_statuts as sc', "$this->table.statut_id", "sc.id")
            ->leftJoin('cc_articles as a', "$this->table.article_id", "a.id")
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->where('article_id', $cond['article_id']);
            })
            ->when(key_exists('commande_id', $cond), function ($q) use ($cond) {
                $q->where('commande_id', $cond['commande_id']);
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where("$this->table.id", $cond['id']);
            })
            ->when(Gate::allows('is_client', [User::class]), function ($q) {
                $q->where(function ($wq) {
                    $wq->whereIn("$this->table.statut_id", [1, 2, 3, 4, 5])
                        ->orWhereNull("$this->table.statut_id");
                });
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
        $statut_options = Loader::CMD_STATUT_EDITFIELD();
        $commande_id = request()->commande_id;
        $commande = Commande::find($commande_id);
        $route_crtmd = Route('commande.ligne.create', [$commande]) . "?&";

        $create_btn =   (Gate::allows('create', [self::class, $commande])) ?
            "<span id='up_{$commande_id}_lcstatut_id_popup'></span><a class='im load-model ui mini green button right floated'
                    data-ref='up_{$commande_id}_lc'
                    style='padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold'
                    data-color='#21ba45' data-url='{$route_crtmd}'
                    data-title='<img src=`/assets/images/app_logo_sq.png` height=`20px` /> <span style=`vertical-align: super;color:#000`>&nbsp;Ajouter Nouvel article</span>'><i
                    class='add icon'></i>&nbsp;Ajouter nouvel article</a>&nbsp;" : "";

        return [
            // [
            //     "name" => "Id",
            //     "data" => "id",
            //     'column' => "id",
            //     "render" => false,
            //     "className" => 'left aligned',
            //     "width" => "75px",
            // ],
            [
                "name" => "Référence",
                "data" => "article.ref",
                'column' => 'article_id',
                "render" => 'relation',
                "className" => 'left aligned',
            ],
            [
                "name" => "Désignation",
                "data" => "designation",
                'column' => 'designation',
                "render" => false,
                "className" => 'left aligned',
            ],
            // [
            //     "name" => "Prix unitaire",
            //     "data" => "pu",
            //     'column' => 'pu',
            //     "render" => false,
            //     "edit" => 'data-field="pu" data-model="/commande/ligne/update" data-type="decimal" data-appends="lcommande=true"',
            //     "className" => 'right aligned',
            // ],
            [
                "name" => "Quantité",
                "data" => "qty",
                'column' => 'qty',
                "render" => false,
                "edit" => 'data-field="qty" data-model="/commande/ligne/update" data-type="number" data-appends="lcommande=true"',
                "className" => 'right aligned  ' . (key_exists('commande_id', $cond) ? (Gate::allows('delete', [Commande::class, Commande::find($cond['commande_id'])]) ? ' editFieldLine' : '') : ' editFieldLine'),
            ],
            [
                "name" => "Statut",
                "data" => "statut.designation",
                'column' => 'statut_id',
                "render" => "relation",
                "edit" => 'data-field="statut_id" data-model="/commande/ligne/update" data-type="drop" data-options="' . $statut_options . '" data-appends="lcommande=true"',
                "className" => 'right aligned  ' . (key_exists('commande_id', $cond) ? (Gate::allows('update', [Commande::class, Commande::find($cond['commande_id'])]) && !Gate::allows('is_client', [User::class]) ? ' editFieldLine' : '') : ' editFieldLine'),
            ],
            // [
            //     "name" => "Total",
            //     "data" => "total",
            //     'column' => 'total',
            //     "render" => false,
            //     "className" => 'right aligned',
            // ],
            [
                "name" => $create_btn,
                "data" => "default",
                'column' => "/handle/render?com=default&model=lcommande&D=D&width=50",
                "render" => 'url',
                "orderable" => false,
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [Commande::class]),
                'width' => "195px"
            ],
        ];
    }

    /**
     * Get article
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }


    /**
     * get commande statut
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statut()
    {
        return $this->belongsTo(Scommande::class, 'statut_id');
    }

    /**
     * Get commande
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'commande_id',
        'article_id',
        'variation',
        'qty',
        'pu',
        'statut_id',
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
        static::updated(function ($_mdl) {
            if ($_mdl->isDirty('statut_id')) {
                $hasNotExpidetLignes = $_mdl->commande->articles()
                    ->where(function ($wq) {
                        $wq->where("statut_id", "!=", 5)
                            ->orWhereNull("statut_id");
                    })->count() == 0;

                if ($hasNotExpidetLignes) {
                    $_mdl->commande->update(['statut_id' => 5]);
                }
            }
        });
    }
}
