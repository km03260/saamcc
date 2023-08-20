<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Mouvement extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "cc_mouvements";

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
            ->with(['sens', 'zone'])
            ->select(DB::raw("$this->table.*, (CASE WHEN sen_id = 1  THEN '#a5eca5' WHEN sen_id = 2 THEN '#ffefd9'  ELSE '#cfdce8' END) AS line_color"))
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->whereHas('stock', function ($qhs) use ($cond) {
                    $qhs->where('cc_stocks.article_id', $cond['article_id']);
                });
            })
            ->when(key_exists('zone_id', $cond), function ($q) use ($cond) {
                $q->where('zone_id', $cond['zone_id']);
            })
            ->when(key_exists('sen_id', $cond), function ($q) use ($cond) {
                $q->where('sen_id', $cond['sen_id']);
            })
            ->when(key_exists('prospect_id', $cond), function ($q) use ($cond) {
                $q->whereHas('article', function ($qha) use ($cond) {
                    $qha->where('cc_articles.prospect_id', $cond['prospect_id']);
                });
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "stock_id",
        "sen_id",
        'zone_id',
        "qte",
        "perte",
    ];


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
                "name" => "Sens",
                'data' => "sens.designation",
                'column' => "sen_id",
                "render" => 'relation',
                "className" => 'left aligned',
                "width" => "75px",
            ],
            [
                "name" => "Zone",
                'data' => "zone.libelle",
                'column' => "zone_id",
                "render" => 'relation',
                "className" => 'left aligned',
            ],
            [
                "name" => "Quantité",
                'data' => "qte",
                'column' => "qte",
                "render" => false,
                "className" => 'right aligned',
                "width" => "75px",
            ],
            [
                "name" => "Perte",
                'data' => "perte",
                'column' => "perte",
                "render" => false,
                "className" => 'right aligned',
                "width" => "75px",
            ],
            [
                "name" => "Date",
                'data' => "created_at",
                'column' => "created_at",
                "render" => false,
                "className" => 'center aligned',
                "width" => "75px",
            ],
        ];
    }

    /**
     * Related stock
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Related direction
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sens()
    {
        return $this->belongsTo(Sen::class, 'sen_id');
    }

    /**
     * Related zone
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

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
