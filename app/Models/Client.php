<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "com_prospects";

    /**
     * Scope grid
     * @param Builder $query
     * @param array $cond
     * @return Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);

        return $query
            ->where([
                "trash" => 0,
                "type" => 'Client',
            ])
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('id', Auth::user()->clients()->first()->id);
            });
    }

    /**
     * Grid Search scope
     *
     * @param Builder $query
     * @param string|null $search
     * @param string|null $selected
     * @param array $cond
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch(Builder $query, String $search = null, String $selected = null, array $cond = [])
    {
        return $query
            ->select(DB::raw("raison_sociale as name, id as value, raison_sociale as text ,
                              CASE WHEN id = '$selected' THEN true ELSE false END AS selected
                    "))
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where("id", $cond['id']);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('raison_sociale', 'LIKE', "%$search%");
                });
            })
            ->where([
                "trash" => 0,
                "type" => 'Client',
            ])
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('id', Auth::user()->clients()->first()->id);
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
                "className" => 'left aligned open_child',
                "width" => "75px",
            ],
            [
                "name" => "Reason sociale",
                "data" => "raison_sociale",
                'column' => 'raison_sociale',
                "render" => false,
                "className" => 'left aligned open_child open item',
            ],
            [
                "name" => "Activité",
                "data" => "activite",
                'column' => 'activite',
                "render" => false,
                "className" => 'left aligned open_child open item',
            ],
            [
                "name" => "business",
                "data" => "business",
                'column' => 'business',
                "render" => false,
                "className" => 'left aligned open_child open item',
            ],
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
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "raison_sociale",
        "type",
        "adresse1",
        "adresse2",
        "cp",
        "ville",
        "pays",
        "activite",
        "siteweb",
        "code_magi_soft",
        "trash",
        "business",
        'account',
    ];

    /**
     * The users that belong to the client.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'cc_client_users');
    }

    /**
     * related commandes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    /**
     * related variations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * related articles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'prospect_id');
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
        static::deleting(function ($_mdl) {
            $_mdl->commandes->each->delete();
            $_mdl->articles->each->delete();
            $_mdl->users()->sync([]);
        });
    }
}
