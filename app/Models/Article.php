<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Article extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "cc_articles";

    protected $appends = ['client_name'];

    /**
     * Scope grid
     * @param Builder $query
     * @param array $cond
     * @return Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);

        return $query->with(['client'])
            ->select(DB::raw("$this->table.*"))
            ->when(key_exists('prospect_id', $cond), function ($q) use ($cond) {
                $q->where('prospect_id', $cond['prospect_id']);
            })
            ->when(key_exists('ref', $cond), function ($q) use ($cond) {
                $q->where('ref', 'LIKE', "{$cond['ref']}%");
            })
            ->when(key_exists('designation', $cond), function ($q) use ($cond) {
                $q->where('designation', 'LIKE', "%{$cond['designation']}%");
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('prospect_id', Auth::user()->clients()->first()->id);
            });
    }

    /**
     * Search scope
     *
     * @param Builder $query
     * @param string|null $search
     * @param string|null $selected
     * @param array $cond
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch(Builder $query, String $search = null, String $selected = null, array $cond = [])
    {
        $_name = key_exists('add', $cond) ? "CONCAT(ref, ' ', CASE WHEN designation IS NOT NULL THEN designation ELSE '' END ) AS name" : "ref AS name";
        return $query
            ->select(DB::raw("$_name, id as value, ref as text , designation as description,id AS value,
                              CASE WHEN id = '$selected' THEN true ELSE false END AS selected
                    "))
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where("id", $cond['id']);
            })
            ->when(key_exists('ids', $cond), function ($q) use ($cond) {
                $q->whereNotIn("id", array_filter(explode(',', $cond['ids'])));
            })
            ->when(key_exists('notin', $cond), function ($q) use ($cond) {
                $q->whereNotIn("id", array_filter(explode(',', $cond['notin'])));
            })
            ->when(key_exists('prospect_id', $cond), function ($q) use ($cond) {
                $q->where('prospect_id', $cond['prospect_id']);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('ref', 'LIKE', "%$search%")
                        ->orWhere('designation', 'LIKE', "%$search%");
                });
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('prospect_id', Auth::user()->clients()->first()->id);
            })
            ->limit(100);
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
                "data" => "ref",
                'column' => 'ref',
                "render" => false,
                "edit" => 'data-field="red" data-model="/article/savewhat" data-type="text"',
                "className" => 'left aligned open_child open ' . (Gate::allows('create', [self::class]) ? 'editFieldLine' : ''),
            ],
            [
                "name" => "Désignation",
                "data" => "designation",
                'column' => 'designation',
                "render" => false,
                "edit" => 'data-field="designation" data-model="/article/savewhat" data-type="text"',
                "className" => 'left aligned open_child open ' . (Gate::allows('create', [self::class]) ? 'editFieldLine' : ''),
            ],
            [
                "name" => "PU",
                "data" => "puht",
                'column' => 'puht',
                "render" => false,
                "edit" => 'data-field="puht" data-model="/article/savewhat" data-type="decimal"',
                "className" => 'right aligned  ' . (Gate::allows('create', [self::class]) ? 'editFieldLine' : ''),
            ],
            [
                "name" => "Client",
                "data" => "client.raison_sociale",
                'column' => 'prospect_id',
                "render" => 'relation',
                'visible' => key_exists('wclient', $cond) && !Gate::allows('is_client', User::class),
                "className" => 'right aligned',
            ],
            [
                "name" => "",
                "data" => "default",
                'column' => "/handle/render?com=default&model=article&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [self::class]),
                'width' => "55px"
            ],
        ];
    }

    /**
     * Get related client
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'prospect_id');
    }

    /**
     * fet stocks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'article_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "prospect_id",
        "ref",
        "designation",
        "puht",
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

    /**
     * Get the user's first name.
     */
    public function clientName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->client->raison_sociale,
        );
    }
}
